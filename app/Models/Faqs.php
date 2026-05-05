<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faqs extends Model
{
    protected $fillable = ['question', 'answer', 'status'];
    use HasFactory;
    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('status', true);
    }
}
