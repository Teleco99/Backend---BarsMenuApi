<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'allergens'];

    protected $casts = [
        'allergens' => 'array',
    ];

    public function menus() : BelongsToMany
    {
        return $this->belongsToMany(Menu::class, 'menu_product');
    }

    // Relación inversa admin->product
    public function admins() : BelongsToMany
    {
        return $this->belongsToMany(Admin::class, 'admin_product', 'product_id', 'admin_id');
    }
}
