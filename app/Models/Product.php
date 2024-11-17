<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'allergens'];

    protected $casts = [
        'allergens' => 'array',
    ];

    // Relación manyToOne menu->product
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    // Relación manyToOne admin->menu->product
    public function admin()
    {
        return $this->menu ? $this->menu->admin : null;

    }
}
