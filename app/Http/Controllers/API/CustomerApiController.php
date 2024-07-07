<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;


class CustomerApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function create(Request $request): JsonResponse
    {
        if (Auth::user()->role !== 'user') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string',
            'image' => 'nullable|image',
            'status' => $request->status ?? 'online',
            'technician_id' => 'nullable|exists:users,id',
            'feedback_message' => 'nullable|string',
            'feedback_rate' => 'nullable|integer|min:1|max:5',
        ]);
        if (Auth::user()->id !== (int)$request->customer_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $ticket = Ticket::create($request->all());

        return response()->json($ticket, 201);
    }
    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);
        if (Auth::user()->id !==$ticket->technician_id && Auth::user()->id !== $ticket->customer_id) 
        {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return response()->json($ticket);
    }
    public function feedback(Request $request)
    {
        if (Auth::user()->role !== 'user') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:tickets,id',
            'feedback_message' => 'nullable|string',
            'feedback_rate' => 'nullable|integer|min:1|max:5',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $ticket = Ticket::find($request->id);
        if (Auth::user()->id !== $ticket->customer_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $ticket->update([
            'feedback_message' => $request->feedback_message,
            'feedback_rate' => $request->feedback_rate,
        ]);

        return response()->json([
            'message' => 'Feedback submitted successfully',
        ], 200);
    }

    public function viewFeedback($id)
    {
        $ticket = Ticket::find($id);

        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        if (Auth::user()->id !== $ticket->customer_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return response()->json([
            'customer_id' => $ticket->user_id,
            'technician_id' => $ticket->technician_id,
            'subject' => $ticket->subject,
            'feedback_message' => $ticket->feedback_message,
            'feedback_rate' => $ticket->feedback_rate,
        ], 200);
    }
}
