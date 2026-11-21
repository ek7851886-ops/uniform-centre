<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'quotation_id', 'user_id', 'total_amount',
        'status', 'expected_delivery_date', 'delivered_at', 'internal_notes',
    ];

    protected $casts = [
        'expected_delivery_date' => 'date',
        'delivered_at' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(QuotationRequest::class, 'quotation_id');
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class)->latest();
    }

    public static function statusSteps(): array
    {
        return [
            'order_confirmed', 'fabric_arranged', 'cutting', 'stitching',
            'embroidery_printing', 'quality_check', 'ready_for_delivery',
            'out_for_delivery', 'delivered',
        ];
    }

    public static function statusLabels(): array
    {
        return [
            'order_confirmed' => 'Order Confirmed',
            'fabric_arranged' => 'Fabric Arranged',
            'cutting' => 'Cutting',
            'stitching' => 'Stitching',
            'embroidery_printing' => 'Embroidery / Printing',
            'quality_check' => 'Quality Check',
            'ready_for_delivery' => 'Ready For Delivery',
            'out_for_delivery' => 'Out For Delivery',
            'delivered' => 'Delivered',
        ];
    }

    public static function generateOrderNumber(): string
    {
        $year = now()->format('Y');
        $count = self::whereYear('created_at', now()->year)->count() + 1;

        return 'ORD-' . $year . '-' . str_pad($count, 5, '0', STR_PAD_LEFT);
    }

    public function statusLabel(): string
    {
        return self::statusLabels()[$this->status] ?? ucfirst(str_replace('_', ' ', $this->status));
    }

    public function statusStepIndex(): int
    {
        $i = array_search($this->status, self::statusSteps(), true);

        return $i === false ? 0 : $i;
    }
}
