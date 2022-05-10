<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Picture extends Model
{
    use HasFactory;

    protected $fillable = ['picture_path', 'name'],
    
    $appends = ['image_url'];

    /**
     * Get the product that owns the Picture
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get Image URL to be shown
     *
     * @return string
     */
    public function getImageUrlAttribute(): string
    {
        return Storage::url($this->picture_path);
    }
}
