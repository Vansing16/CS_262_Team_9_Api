<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Technician extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'date_of_birth', 'nationality', 'profile_image', 'status'
    ];

    // Automatically hash the password
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($technician) {
            if ($technician->isDirty('password')) {
                $technician->password = Hash::make($technician->password);
            }
        });

        static::saved(function ($technician) {
            // Update or create the corresponding user record
            User::updateOrCreate(
                ['email' => $technician->email],
                [
                    'name' => $technician->name,
                    'password' => $technician->password,
                    'profile_image' => $technician->profile_image,
                    'role' => 'technician'
                ]
            );
        });
    }
}
