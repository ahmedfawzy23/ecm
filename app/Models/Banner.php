<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['image','status'];
        #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('status', true);
    }
}
