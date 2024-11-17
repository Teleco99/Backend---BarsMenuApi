<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Admin extends User
{
    // Relación oneToMany admin->menu
    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }

    // Relación oneToMany admin->menu->product
    public function products(): HasManyThrough
    {
        return $this->hasManyThrough(Menu::class, Product::class);
    }
}
