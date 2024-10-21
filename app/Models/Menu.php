<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Menu extends Model
{
    protected $fillable = ['name'];

    public function products() : BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'menu_product');
    }

    // Relación inversa admin->menu
    public function admins() : BelongsToMany
    {
        return $this->belongsToMany(Admin::class, 'admin_product', 'menu_id', 'admin_id');
    }
}
