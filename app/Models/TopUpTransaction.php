<?php

namespace App\Models;

use App\Enums\TopUpStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TopUpTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'provider',
        'provider_reference',
        'request_payload',
        'response_payload',
        'status',
        'attempt',
        'processed_at',
    ];

    protected $casts = [
        'status' => TopUpStatus::class,
        'request_payload' => 'array',
        'response_payload' => 'array',
        'attempt' => 'integer',
        'processed_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
