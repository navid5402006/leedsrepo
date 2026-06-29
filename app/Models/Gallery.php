<?php
// app/Models/Gallery.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    // Remove: use SoftDeletes;
    
    protected $fillable = [
        'title',
        'image',
        'description',
        'category',
        'status',
        'order',
    ];

    protected $casts = [
        'status' => 'boolean',
        'order' => 'integer',
    ];

    // Scope for active items
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    // Scope for ordering
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('id', 'desc');
    }

    // Get image URL
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image);
    }
}