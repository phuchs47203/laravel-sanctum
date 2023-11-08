<?php

namespace App\Models;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

//  php artisan make:model Comment --migration
class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'inventory',
        'brand',
        'sold',
        'user_id'
    ];
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'foreign_key');
    }
    
}
