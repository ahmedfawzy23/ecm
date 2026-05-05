<?php

namespace App\Models;

use Database\Factories\SubCategoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['category_id', 'name', 'status', 'image'])]
class SubCategory extends Model
{
    use HasFactory;

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Database\Factories\SubCategoryFactory
     */
    protected static function newFactory(): SubCategoryFactory
    {
        return SubCategoryFactory::new();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
