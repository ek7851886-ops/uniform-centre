<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'description',
        'fabric_options', 'color_options', 'customization_options', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'customization_options' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->images()->where('is_primary', true)->first() ?? $this->images()->first();
    }

    public function quotationRequests(): HasMany
    {
        return $this->hasMany(QuotationRequest::class);
    }

    public function fabricList(): array
    {
        return $this->fabric_options ? array_map('trim', explode(',', $this->fabric_options)) : [];
    }

    public function colorList(): array
    {
        return $this->color_options ? array_map('trim', explode(',', $this->color_options)) : [];
    }

    public function customizationBadges(): array
    {
        $map = [
            'logo' => 'Logo Embroidery',
            'printing' => 'Printing',
            'reflective' => 'Reflective Strips',
            'name_embroidery' => 'Name Embroidery',
            'custom_measurements' => 'Custom Measurements',
        ];

        return collect($this->customization_options ?? [])
            ->map(fn ($key) => $map[$key] ?? ucfirst(str_replace('_', ' ', $key)))
            ->all();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
