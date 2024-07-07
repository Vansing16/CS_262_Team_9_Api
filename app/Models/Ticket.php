<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'subject', 'message', 'customer_id', 'technician_id', 'status', 'image','feedback_message',
        'feedback_rate',
    ];

    /**
     * Define the relationship with User model (assuming User model represents customers).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Define the relationship with User model (assuming User model represents technicians).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    /**
     * Display tickets assigned to the current technician.
     *
     * @return \Illuminate\View\View
     */
    public static function showTechnicianTickets()
    {
        // Assuming you have authenticated technician and technician_id stored in session or authenticated user
        $technicianId = auth()->user()->technician_id;

        // Fetch tickets assigned to the current technician
        $tickets = Ticket::where('technician_id', $technicianId)->get();

        // Pass the tickets to the view
        return view('technician.tickets', compact('tickets'));
    }
}
