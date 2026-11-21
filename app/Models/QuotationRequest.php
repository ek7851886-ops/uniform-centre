<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class QuotationRequest extends Model
{
    protected $fillable = [
        'quote_number', 'user_id', 'product_id',
        'company_name', 'contact_person', 'email', 'phone', 'company_address',
        'category', 'quantity', 'preferred_fabric', 'preferred_color', 'sizes',
        'logo_required', 'logo_path', 'embroidery_required', 'printing_required',
        'reflective_strips_required', 'name_embroidery_required', 'additional_requirements',
        'required_delivery_date', 'delivery_city', 'delivery_address',
        'status', 'price_per_unit', 'embroidery_charges', 'printing_charges',
        'delivery_charges', 'other_charges', 'discount', 'grand_total', 'admin_notes',
    ];

    protected $casts = [
        'sizes' => 'array',
        'logo_required' => 'boolean',
        'embroidery_required' => 'boolean',
        'printing_required' => 'boolean',
        'reflective_strips_required' => 'boolean',
        'name_embroidery_required' => 'boolean',
        'required_delivery_date' => 'date',
        'price_per_unit' => 'decimal:2',
        'embroidery_charges' => 'decimal:2',
        'printing_charges' => 'decimal:2',
        'delivery_charges' => 'decimal:2',
        'other_charges' => 'decimal:2',
        'discount' => 'decimal:2',
        'grand_total' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class, 'quotation_id');
    }

    public static function generateQuoteNumber(): string
    {
        $year = now()->format('Y');
        $count = self::whereYear('created_at', now()->year)->count() + 1;

        return 'Q-' . $year . '-' . str_pad($count, 5, '0', STR_PAD_LEFT);
    }

    public function subtotal(): float
    {
        return (float) $this->price_per_unit * (int) $this->quantity;
    }

    public function calculateGrandTotal(): float
    {
        return $this->subtotal()
            + (float) $this->embroidery_charges
            + (float) $this->printing_charges
            + (float) $this->delivery_charges
            + (float) $this->other_charges
            - (float) $this->discount;
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending' => 'Pending',
            'under_review' => 'Under Review',
            'quoted' => 'Quotation Sent',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            default => ucfirst($this->status),
        };
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'pending' => 'secondary',
            'under_review' => 'info',
            'quoted' => 'primary',
            'approved' => 'success',
            'rejected' => 'danger',
            default => 'secondary',
        };
    }
}
