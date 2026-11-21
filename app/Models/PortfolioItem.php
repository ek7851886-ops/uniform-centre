<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioItem extends Model
{
    protected $fillable = ['title', 'category', 'image_path', 'description', 'client_name', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public static function categories(): array
    {
        return ['Corporate', 'Industrial', 'Embroidery', 'Hospitality', 'Security'];
    }
}
