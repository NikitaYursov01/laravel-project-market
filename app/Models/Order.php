<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'title',
        'category',
        'budget',
        'description',
        'materials',
        'location',
        'completion_date',
        'technical_requirements',
        'user_id',
        'status',
        'type',
    ];

    protected $casts = [
        'completion_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(OrderImage::class)->orderBy('order');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeClientOrders($query)
    {
        return $query->where('type', 'client_order');
    }

    public function scopePerformerServices($query)
    {
        return $query->where('type', 'performer_service');
    }

    public function isClientOrder(): bool
    {
        return $this->type === 'client_order';
    }

    public function isPerformerService(): bool
    {
        return $this->type === 'performer_service';
    }
}
