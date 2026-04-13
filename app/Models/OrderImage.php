<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderImage extends Model
{
    protected $fillable = [
        'order_id',
        'path',
        'original_name',
        'order',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getUrl(): string
    {
        return asset('storage/' . $this->path);
    }
}
