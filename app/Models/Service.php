<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'status',      // new: Available or Unavailable
        'materials',   // new: comma-separated list e.g. "PLA, ABS, PETG"
    ];

    // Default values
    protected $attributes = [
        'status' => 'Available',
        'materials' => '',
    ];

    // Helper for badge color
    public function getStatusBadgeClass(): string
    {
        return $this->status === 'Available' ? 'bg-green-600 text-white' : 'bg-red-600 text-white';
    }

    // Format materials as array
    public function getMaterialsArray(): array
    {
        return $this->materials ? array_map('trim', explode(',', $this->materials)) : [];
    }
}