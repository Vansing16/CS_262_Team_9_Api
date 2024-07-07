<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'profile'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Automatically hash the password
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($customer) {
            if ($customer->isDirty('password')) {
                $customer->password = Hash::make($customer->password);
            }
        });

        static::saved(function ($customer) {
            // Update or create the corresponding user record
            User::updateOrCreate(
                ['email' => $customer->email],
                [
                    'name' => $customer->name,
                    'password' => $customer->password,
                    'profile_image' => $customer->profile_image,
                    'role' => 'user'
                ]
            );
        });
    }
}
