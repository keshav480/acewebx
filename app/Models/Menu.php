<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    // Explicit table name (optional, but safe)
    protected $table = 'menus';

    // Mass assignable columns
    protected $fillable = [
        'name',
        'data',
    ];

    // Cast 'data' column to array automatically
    protected $casts = [
        'data' => 'array',
    ];
}
