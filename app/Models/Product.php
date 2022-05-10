<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Collection, Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, HasOne};
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['category_id', 'name', 'description', 'stock'],

    $appends = ['image_url'];

    private const PRODDIR = 'products';

    /**
     * Get the category that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all of the variants for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class);
    }

    /**
     * Get all of the pictures for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pictures(): HasMany
    {
        return $this->hasMany(Picture::class);
    }

    /**
     * Get the firstPicture associated with the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function firstPicture(): HasOne
    {
        return $this->hasOne(Picture::class)->oldestOfMany();
    }

    /**
     * Move temp images to categories folder
     *
     * @param array|null $images
     * @return Product
     */
    public function moveImages(array $images = null): Product
    {
        if (empty($images)) {
            return $this;
        }
        
        // Upload images
        foreach (Temp::find($images) as $key => $temp) {
            $this->pictures()->create([
                'name' => $temp->name,
                'picture_path' => $temp->movePublicly(self::PRODDIR)
            ]); 
        }
        
        return $this;

    }

    /**
     * Get Image URL to be shown
     *
     * @return string
     */
    public function getImageUrlAttribute(): string
    {
        return $this->firstPicture
        ? Storage::url($this->firstPicture->picture_path)
        : $this->defaultImageUrl();
    }

    /**
     * Default Image URL for Products
     *
     * @return string
     */
    protected function defaultImageUrl(): string
    {
        return ''/* asset('storage/products/test.png') */;
    }

}
