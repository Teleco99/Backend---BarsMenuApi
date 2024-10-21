<?php

namespace App\Models;

class Admin extends User
{
	// Los Admins usan la tabla de usuarios
	protected $table = 'users';

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'admin_menu');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'admin_product');
    }
}
