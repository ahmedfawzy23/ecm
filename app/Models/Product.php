<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[Fillable([
    'name',
    'price',
    'description',
    'sub_category_id',
        'quantity',
])]
class Product extends Model  implements HasMedia
{
    use HasFactory ,InteractsWithMedia;

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
