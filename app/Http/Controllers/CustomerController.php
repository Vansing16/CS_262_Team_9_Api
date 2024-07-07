<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\Message;

class CustomerController extends Controller
{
    public function index()
    {
        $tickets = Ticket::where('customer_id', Auth::id())->get();
        return view('customer.dashboard', compact('tickets'));
    }

    public function createTicket()
    {
        return view('customer.create-ticket');
    }

    public function storeTicket(Request $request)
    {
        $validatedData = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'image' => 'nullable|image|max:4096',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = now()->format('Ymd_His') . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('ticket_images', $imageName, 'public');
            $validatedData['image'] = $imagePath;
        }

        $ticket = new Ticket();
        $ticket->customer_id = Auth::id();
        $ticket->subject = $validatedData['subject'];
        $ticket->message = $validatedData['message'];

        // Assign image path if uploaded
        if (isset($validatedData['image'])) {
            $ticket->image = $validatedData['image'];
        }

        $ticket->save();
        return redirect()->route('customer.ticket')->with('success', 'Ticket created successfully!');
    }

    public function showTicket()
    {
        $customerId = Auth::id();
        $tickets = Ticket::where('customer_id', $customerId)->get();
        return view('customer.ticket', compact('tickets'));
    }

    public function viewTicket($ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);
    
        return view('customer.view-ticket', compact('ticket'));
    }

    public function message($ticketId = null)
    {
        $customerId = Auth::id();
        $messages = Message::whereHas('ticket', function ($query) use ($customerId) {
            $query->where('customer_id', $customerId);
        })->get();

        $filteredMessages = $messages->sortByDesc('created_at')->groupBy('ticket_id')->map->first();

        return view('customer.message', compact('filteredMessages', 'ticketId'));
    }

    public function sendMessage(Request $request)
    {
        $validatedData = $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'message' => 'nullable|string',
            'image' => 'nullable|image|max:4096', // Max size 4MB (4096KB)
        ]);
    
        $customerId = Auth::id();
    
        $ticket = Ticket::findOrFail($validatedData['ticket_id']);
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = now()->format('Ymd_His') . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('message_images', $imageName, 'public');
            $validatedData['image'] = $imagePath;
        }
    
        // Create a new Message instance
        $message = new Message();
        $message->ticket_id = $ticket->id;
        $message->customer_id = $customerId;
        $message->technician_id = $ticket->technician_id;
        $message->sender_type = 'customer';
        $message->message = $validatedData['message'];
    
        // Assign image path if uploaded
        if (isset($validatedData['image'])) {
            $message->image = $validatedData['image'];
        }
    
        $message->save();
    
        // Redirect to the specific ticket view with the latest message ID
        $latestMessageId = Message::where('ticket_id', $ticket->id)
            ->orderByDesc('created_at')
            ->value('id');
    
        return redirect()->route('customer.view-message', ['messageId' => $latestMessageId])
            ->with('success', 'Message sent successfully!');
    }

    public function setting()
    {
        $customer = Auth::user();
        return view('customer.setting', compact('customer'));
    }
    

    public function viewMessage($messageId)
    {
        $customerId = Auth::id();
        $message = Message::findOrFail($messageId);
        $ticketId = $message->ticket_id;
    
        $ticket = Ticket::where('id', $ticketId)
            ->where('customer_id', $customerId)
            ->firstOrFail();
    
        $messages = Message::where('ticket_id', $ticketId)
            ->with('technician')
            ->orderBy('created_at', 'asc') // Sort messages in ascending order
            ->get();
    
        return view('customer.view-message', compact('ticket', 'messages'));
    }

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

        $customer = Auth::user();

        $customer->name = $validatedData['name'];
        $customer->email = $validatedData['email'];
        $customer->phone = $validatedData['phone'];
        $customer->nationality = $validatedData['nationality'];

        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $imageName = 'profile_images/' . $customer->id . '_' . date('Ymd_His') . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('', $imageName, 'public');

            $customer->profile_image = $imageName;
        }

        if (!empty($validatedData['newPassword'])) {
            $customer->password = bcrypt($validatedData['newPassword']);
        }

        $customer->save();

        return redirect()->route('customer.setting')->with('success', 'Profile updated successfully!');
    }

    public function editSettings()
    {
        // Fetch technician settings data (example)
        $customer = auth()->user(); // Assuming technician information is in the user model

        // Return view with technician settings form
        return view('customer.setting', compact('customer'));
    }

    /**
     * Display the feedback form for a specific ticket.
     *
     * @param  int  $ticketId
     * @return \Illuminate\View\View
     */
    public function sendFeedback($ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);

        return view('customer.send-feedback', [
            'ticket' => $ticket,
        ]);
    }

    /**
     * Process the feedback form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $ticketId
     * @return \Illuminate\Http\RedirectResponse
     */

     public function postFeedback(Request $request, $ticketId)
     {
         // Validate the request data
         $request->validate([
             'feedback' => 'required|string',
             'rating' => 'required|integer|min:1|max:5', // Add validation for rating
         ]);
     
         // Find the ticket
         $ticket = Ticket::findOrFail($ticketId);
     
         // Save feedback message and rating in tickets table
         $ticket->feedback_message = $request->input('feedback');
         $ticket->feedback_rate = $request->input('rating');
         $ticket->save();
     
         // Redirect back with success message
         return redirect()->route('customer.view-ticket', ['ticketId' => $ticketId])
             ->with('success', 'Feedback submitted successfully.');
     }
     
}
