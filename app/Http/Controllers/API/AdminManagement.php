<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use App\Models\Admin;
use App\Models\Message;

class AdminManagement extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    protected function isAdmin()
    {
        return Auth::id() == env('ADMIN_USER_ID');
    }

    public function allTicket()
    {
        if (!$this->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $tickets = Ticket::all();
        return response()->json($tickets);
    }
    public function index()
    {
        if (!$this->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $user = User::all();
        return response()->json($user);
    }

    public function create(Request $request): JsonResponse
    {
        if (!$this->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:50',
                'email' => 'required|email',
                'password' => 'required|string|min:6',
                'phone' => 'required',
                'profile_image' => 'nullable|image',
                'date_of_birth' => 'nullable',
                'nationality' => 'nullable',
                'status' => 'nullable|in:idle,online,offline',
                'role' => 'nullable|in:user,technician',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'nationality' => $request->nationality,
            'profile_image' => $request->file('profile_image') ? $request->file('profile_image')->store('profile_images', 'public') : null,
            'status' => $request->status ?? 'idle',
            'role' => $request->role ?? 'user',
        ]);
        $success['token'] = $user->createToken('Token')->plainTextToken;
        $success['message'] = $user;
        return response()->json($success, 201);
    }

    public function update(Request $request)
    {
        if (!$this->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
            'name' => 'nullable|string|max:50',
            'email' => 'nullable|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = Admin::findOrFail($request->id);
        $user->update($request->only(['name', 'email']));

        return response()->json('Update Success!', 200);
    }

    public function showUser($id)
    {
        if (!$this->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return User::findOrFail($id);
    }

    public function showTicket($id)
    {
        if (!$this->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return Ticket::findOrFail($id);
    }

    public function destroyTicket($id)
    {
        if (!$this->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return response()->json(['message' => 'Ticket is Deleted!'], 202);
    }

    public function destroyUser($id)
    {
        if (!$this->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $user = User::findOrFail($id);

        // Check if the user is a technician
        if ($user->role === 'technician') {
            $ticketsAsTechnician = Ticket::where('technician_id', $id)->get();

            // Delete all messages where the user is a technician
            foreach ($ticketsAsTechnician as $ticket) {
                Message::where('ticket_id', $ticket->id)->delete();
                $ticket->technician_id = null; // Unassign technician
                $ticket->save();
            }
        } else {
            $ticketsAsCustomer = Ticket::where('customer_id', $id)->get();
            $ticketsAsTechnician = Ticket::where('technician_id', $id)->get();

            // Delete all tickets and messages where the user is a customer
            foreach ($ticketsAsCustomer as $ticket) {
                Message::where('ticket_id', $ticket->id)->delete();
                $ticket->delete();
            }

            // Delete all messages where the user is a technician
            foreach ($ticketsAsTechnician as $ticket) {
                Message::where('ticket_id', $ticket->id)->delete();
                $ticket->technician_id = null; // Unassign technician
                $ticket->save();
            }
        }

        $user->delete();

        return response()->json(['message' => 'User: ' . $user->name . ' is deleted'], 202);
    }


    public function assignTicket(Request $request)
    {
        if (!$this->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'ticket_id' => 'required|exists:tickets,id',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $ticket = Ticket::find($request->ticket_id);

        if (!$ticket) {
            return response()->json(['error' => 'Ticket not found'], 404);
        }

        $ticket->technician_id = $user->id;
        $ticket->save();

        return response()->json(['message' => 'Ticket is assigned to ' . $user->name], 200);
    }

    public function viewFeedback($id)
    {
        $user = Auth::user();
        $ticket = Ticket::findOrFail($id);

        if (!$this->isAdmin() && $user->id !== $ticket->technician_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'customer_id' => $ticket->customer_id,
            'technician_id' => $ticket->technician_id,
            'subject' => $ticket->subject,
            'feedback_message' => $ticket->feedback_message,
            'feedback_rate' => $ticket->feedback_rate,
        ], 200);
    }
}
