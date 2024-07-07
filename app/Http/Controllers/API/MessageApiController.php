<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class MessageApiController extends Controller
{
    protected function isAdmin()
    {
        return Auth::id() == env('ADMIN_USER_ID');
    }
    public function sendMessage(Request $request)
    {
        if (Auth::user()->role !== 'user') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required|exists:tickets,id',
            'message' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        $ticket = Ticket::findOrFail($request->ticket_id);
    
        if (Auth::user()->id !== $ticket->customer_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    
        $message = Message::create([
            'ticket_id' => $request->ticket_id,
            'customer_id' => $ticket->customer_id,
            'technician_id' => $ticket->technician_id,
            'sender_type' => 'customer',
            'message' => $request->message,
            'image' => $request->image,
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully!',
            'data' => $message
        ], 201);
    }
    public function MakeMessage(Request $request)
    {
        if (Auth::user()->role !== 'technician') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required|exists:tickets,id',
            'message' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $ticket = Ticket::findOrFail($request->ticket_id);
        if (Auth::user()->id !== $ticket->technician_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $message = Message::create([
            'ticket_id' => $request->ticket_id,
            'customer_id' => $ticket->customer_id,
            'technician_id' => $ticket->technician_id,
            'sender_type' => 'technician',
            'message' => $request->message,
            'image' => $request->image,
        ]);

        $message->save();

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully!',
            'data' => $message
        ], 201);
    }

    public function viewMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required|exists:tickets,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $ticketId = $request->input('ticket_id');

        try {

            $messages = Message::where('ticket_id', $ticketId)
                ->orderBy('created_at', 'asc')
                ->get();

            $ticket = Ticket::findOrFail($ticketId);
            if (!$this->isAdmin() && Auth::user()->id !== $ticket->customer_id && Auth::user()->id !== $ticket->technician_id) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
            $showticket = [
                'id' => $ticket->id,
                'subject' => $ticket->subject,
                'message' => $ticket->message,

            ];

            $showmessage = $messages->map(function ($message) {
                return [
                    'sender' => $message->sender_type,
                    'message' => $message->message,
                ];
            });
            return response()->json([
                'ticket' => $showticket,
                'messages' => $showmessage,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve messages.'], 500);
        }
    }
    public function updateStatus(Request $request)
    {
        $validator = ticket::where('id', $request->id)->update([
            'status' => $request->status,
        ]);
        if (!$validator) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        return response()->json(['message' => 'Status change'], 200);
    }
}
