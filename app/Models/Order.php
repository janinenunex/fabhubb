<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // These columns can be filled when creating/updating
    protected $fillable = [
        'user_id',
        'service_id',
        'quantity',
        'status',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    // === STEP 1: Define the 4 statuses ===
    const STATUS_PENDING = 'Pending';
    const STATUS_PROCESSING = 'Processing';
    const STATUS_READY = 'Ready for Pickup';
    const STATUS_COMPLETED = 'Completed';

    // This is the correct order of statuses
    public static $statuses = [
        self::STATUS_PENDING,
        self::STATUS_PROCESSING,
        self::STATUS_READY,
        self::STATUS_COMPLETED,
    ];

    // Relationships (you already have these)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Calculate total price
    public function getTotalPrice(): float
    {
        return $this->quantity * $this->service->price;
    }

    // === STEP 2: Helper to get the NEXT status ===
public function getNextStatus(): ?string
{
    // Normalize status for comparison (handle case differences)
    $normalizedStatuses = array_map('strtolower', self::$statuses);
    $currentNormalized = strtolower($this->status);

    $currentPosition = array_search($currentNormalized, $normalizedStatuses);

    if ($currentPosition === false || $currentPosition === count(self::$statuses) - 1) {
        return null;
    }

    return self::$statuses[$currentPosition + 1];
}

    // === STEP 3: Helper to get color for the status badge ===
    public function getStatusBadgeClass(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'bg-orange-600 text-white',
            self::STATUS_PROCESSING => 'bg-blue-600 text-white',
            self::STATUS_READY => 'bg-purple-600 text-white',
            self::STATUS_COMPLETED => 'bg-green-600 text-white',
            default => 'bg-gray-600 text-white',
        };
    }
}