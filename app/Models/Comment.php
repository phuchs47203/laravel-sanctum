<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'reviews',
        'product_id',
        'star'
    ];


    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'foreign_key');
    }
}
