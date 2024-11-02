<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Menu;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'userUser',
            'password' => 'password',
            'email' => 'test@example.com',
            'role' => 'user',
        ]);

        $user = User::create([
            'name' => 'adminUser',
            'password' => 'test',
            'email' => 'test@test.com',
            'role' => 'admin',
        ]);

        Product::create([
            'name' => 'Pizza Margherita',
            'description' => 'Tomato, mozzarella, and basil.',
            'price' => '11',
            'allergens' => ['gluten', 'lactose'],
        ]);

        Product::create([
            'name' => 'Cheeseburger',
            'description' => 'Beef patty, cheese, lettuce, and tomato.',
            'price' => '13.69',
            'allergens' => ['gluten', 'lactose'],
        ]);

        Product::create([
            'name' => 'Caesar Salad',
            'description' => 'Romaine lettuce, croutons, and Caesar dressing.',
            'price' => '8.3',
            'allergens' => ['egg', 'gluten'],
        ]);

        Product::create([
            'name' => 'Tacos de Pollo',
            'description' => 'Tortilla de maíz rellena de pollo asado, salsa picante y cebolla.',
            'price' => '9',
            'allergens' => ['gluten'],
        ]);

        Product::create([
            'name' => 'Sopa de Tomate',
            'description' => 'Sopa cremosa de tomate con un toque de albahaca fresca.',
            'price' => '7',
            'allergens' => ['lactosa'],
        ]);

        Product::create([
            'name' => 'Mazamorra',
            'description' => 'Crema de almendras con uvas cortadas por la mitad.',
            'price' => '6.66',
            'allergens' => ['lactosa'],
        ]);

        $menu1 = Menu::create([
            'name' => 'Menu Bar Antonio'
        ]);

        $menu2 = Menu::create([
            'name' => 'Menu MCdonald'
        ]);

        // Asociamos los productos si están presentes
        $menu1->products()->sync([4, 5, 6]);
        $menu2->products()->sync([1, 2, 3]);

        // Asociamos menus a usuarios
        $admin = Admin::findOrFail($user->id);
        $admin->menus()->sync($menu1->id);
        $admin->products()->sync([4, 5, 6]);
    }
}
