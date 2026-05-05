<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'status'])]
class Category extends Model
{
    use HasFactory;
    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('status', true);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany */
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Database\Factories\CategoryFactory
     */
    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }
}
