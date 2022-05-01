<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id'],
    
    $appends = ['image_url'],
    
    $disk = 'public';

    /**
     * Get all of the products for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get all of the categories for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Get all of the childrenCategories for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childrenCategories(): HasMany
    {
        return $this->categories()->with('childrenCategories');
    }

    /**
     * Get the category that owns the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the parentCategory that owns the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentCategory(): BelongsTo
    {
        return $this->category()->with('parentCategory');
    }

    /**
     * Get Image URL to be shown
     *
     * @return string
     */
    public function getImageUrlAttribute(): string
    {
        return $this->image_path
        ? Storage::url($this->image_path)
        : $this->defaultImageUrl();
    }

    /**
     * Default Image URL for Category
     *
     * @return string
     */
    protected function defaultImageUrl(): string
    {
        return ''/* asset('storage/category/test.png') */;
    }
}
