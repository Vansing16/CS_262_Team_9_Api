<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\Message;

class TechnicianController extends Controller
{
    public function index()
    {
        $technicianId = Auth::id();
        
        // Fetch recent messages for the logged-in technician
        $messages = Message::where('technician_id', $technicianId)
                            ->with('ticket') // Include the related Ticket model
                            ->orderBy('created_at', 'desc')
                            ->take(5) // Limit to the 5 most recent messages
                            ->get();
    
        // Fetch pending tickets for the logged-in technician
        $pendingTickets = Ticket::where('technician_id', $technicianId)
                                ->where('status', 'Pending')
                                ->get();
    
        return view('technician.dashboard', compact('messages', 'pendingTickets'));
    }       

    /**
     * Display a listing of the tickets for the authenticated technician.
     *
     * @return \Illuminate\View\View
     */
    public function showTechnicianTickets()
    {
        $technicianId = Auth::id();
        $tickets = Ticket::where('technician_id', $technicianId)->get();
        return view('technician.ticket', compact('tickets'));
    }

    /**
     * Display the specified ticket and its messages.
     *
     * @param  int  $ticketId
     * @return \Illuminate\View\View
     */
    public function viewTicket($ticketId)
    {
        $technicianId = Auth::id();
        $ticket = Ticket::where('id', $ticketId)
                        ->where('technician_id', $technicianId)
                        ->firstOrFail();
        $messages = Message::where('ticket_id', $ticketId)->get();
        return view('technician.view-ticket', compact('ticket', 'messages'));
    }

    /**
     * Show the form for creating a new message.
     *
     * @param  int  $ticketId
     * @return \Illuminate\View\View
     */
    public function createMessage($ticketId)
    {
        return view('technician.create-message', compact('ticketId'));
    }

    /**
     * Store a newly created message in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeMessage(Request $request)
    {
        $validatedData = $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'message' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
        ]);

        $technicianId = Auth::id();
        $ticketId = $validatedData['ticket_id'];
        $ticket = Ticket::findOrFail($ticketId);
        $customerId = $ticket->customer_id;

        // Handle image upload and rename
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'message_images/' . date('Ymd_His') . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('', $imageName, 'public');
        }

        $message = new Message();
        $message->ticket_id = $ticketId;
        $message->customer_id = $customerId; // Store customer_id
        $message->technician_id = $technicianId;
        $message->sender_type = 'technician';
        $message->message = $validatedData['message'];
        $message->image = $imagePath;

        $message->save();

        // Redirect to the specific message view after saving the message
        return redirect()->route('technician.view-message', ['messageId' => $message->id])
                        ->with('success', 'Message sent successfully!');
    }

    /**
     * Update the status of the specified ticket.
     *
     * @param  int  $ticketId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateTicketStatus($ticketId, Request $request)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:Pending,Ongoing,Completed,Cancelled',
        ]);

        $technicianId = Auth::id();
        $ticket = Ticket::where('id', $ticketId)
                        ->where('technician_id', $technicianId)
                        ->firstOrFail();

        $ticket->status = $validatedData['status'];
        $ticket->save();

        return redirect()->back()->with('success', 'Ticket status updated successfully!');
    }

    /**
     * Show the message view.
     *
     * @return \Illuminate\View\View
     */
    public function message()
    {
        $messages = Message::where('technician_id', Auth::id())->get();
        return view('technician.message', compact('messages'));
    }

    /**
     * Show the setting view.
     *
     * @return \Illuminate\View\View
     */
    public function setting()
    {
        return view('technician.setting');
    }

    /**
     * Display the specified message.
     *
     * @param  int  $messageId
     * @return \Illuminate\View\View
     */
    public function viewMessage($messageId)
    {
        $message = Message::findOrFail($messageId);
        $conversation = Message::where('ticket_id', $message->ticket_id)->get(); // Fetch all messages related to the ticket
    
        return view('technician.view-message', compact('message', 'conversation'));
    }

    /**
     * Delete the specified message.
     *
     * @param  int  $messageId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteMessage($messageId)
    {
        $message = Message::findOrFail($messageId);
        $message->delete();

        return redirect()->route('technician.dashboard')->with('success', 'Message deleted successfully!');
    }

    public function editSettings()
    {
        // Fetch technician settings data (example)
        $technician = auth()->user(); // Assuming technician information is in the user model

        // Return view with technician settings form
        return view('technician.setting', compact('technician'));
    }
    
    /**
     * Update technician profile settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettings(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'newPassword' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'nationality' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        $technician = Auth::user();

        $technician->name = $validatedData['name'];
        $technician->email = $validatedData['email'];
        $technician->phone = $validatedData['phone'];
        $technician->nationality = $validatedData['nationality'];

        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $imageName = 'profile_images/' . $technician->id . '_' . date('Ymd_His') . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('', $imageName, 'public');

            $technician->profile_image = $imageName;
        }

        if (!empty($validatedData['newPassword'])) {
            $technician->password = bcrypt($validatedData['newPassword']);
        }

        $technician->save();

        return redirect()->route('technician.setting')->with('success', 'Profile updated successfully!');
    }

    public function showNavbar()
    {
        $technician = Auth::user(); // Assuming Auth::user() returns the logged-in technician
        
        return view('technician.layout.navbar', compact('technician'));
    }

}    

