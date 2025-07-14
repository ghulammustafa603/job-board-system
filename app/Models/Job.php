<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    // Add this property:
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'gender',
        'skills',
        'city',
        'cv',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}