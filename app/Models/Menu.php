<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menu extends Model
{
    protected $fillable = ['name'];

    // Relaci¨®n oneToMany menu->product
    public function products(): hasMany
    {
        return $this->hasMany(Product::class);
    }

    // Relaci¨®n manyToOne menu->admin
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
