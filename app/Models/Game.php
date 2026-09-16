<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'logo',
        'banner',
        'is_active',
        'requires_user_id',
        'requires_server_id',
        'user_id_label',
        'server_id_label',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'requires_user_id' => 'boolean',
        'requires_server_id' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->orderBy('sort_order', 'asc');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
