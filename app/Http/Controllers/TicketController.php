<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'image' => 'nullable|image|max:4096', // Adjust max size and file types as needed
        ]);

        // Logic to create a new ticket in the database
        // Example: save data to the database, handle file uploads, etc.

        // Redirect or return a response
        return redirect()->route('customer.ticket')->with('success', 'Ticket created successfully!');
    }
}
