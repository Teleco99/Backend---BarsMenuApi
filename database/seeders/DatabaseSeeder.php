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
        ]);

        $admin = Admin::create([
            'name' => 'admin',
            'password' => 'test',
            'email' => 'test@test.com',
        ]);
        
        $admin2 = Admin::create([
            'name' => 'admin',
            'password' => 'jaqueMate17',
            'email' => 'user1@test.com',
        ]);
        
        $admin3 = Admin::create([
            'name' => 'admin',
            'password' => 'jaqueMate17',
            'email' => 'user2@test.com',
        ]);
        
        $menu1 = Menu::create([
            'name' => 'Menu Bar Antonio'
        ]);

        $menu2 = Menu::create([
            'name' => 'Menu MCdonald'
        ]);
        
        $menu3 = Menu::create([
            'name' => 'Menu Bar Antonio'
        ]);

        $menu4 = Menu::create([
            'name' => 'Menu MCdonald'
        ]);

        $product1 = new Product([
            'name' => 'Pizza Margherita',
            'description' => 'Tomato, mozzarella, and basil.',
            'price' => '11',
            'allergens' => ['gluten', 'lactose'],
        ]);

        $product2 = new Product([
            'name' => 'Cheeseburger',
            'description' => 'Beef patty, cheese, lettuce, and tomato.',
            'price' => '13.69',
            'allergens' => ['gluten', 'lactose'],
        ]);

        $product3 = new Product([
            'name' => 'Caesar Salad',
            'description' => 'Romaine lettuce, croutons, and Caesar dressing.',
            'price' => '8.3',
            'allergens' => ['egg', 'gluten'],
        ]);

        $product4 = new Product([
            'name' => 'Tacos de Pollo',
            'description' => 'Tortilla de maíz rellena de pollo asado, salsa picante y cebolla.',
            'price' => '9',
            'allergens' => ['gluten'],
        ]);

        $product5 = new Product([
            'name' => 'Sopa de Tomate',
            'description' => 'Sopa cremosa de tomate con un toque de albahaca fresca.',
            'price' => '7',
            'allergens' => ['lactosa'],
        ]);

        $product6 = new Product([
            'name' => 'Mazamorra',
            'description' => 'Crema de almendras con uvas cortadas por la mitad.',
            'price' => '6.66',
            'allergens' => ['lactosa'],
        ]);
        
        $product7 = new Product([
            'name' => 'Pizza Margherita',
            'description' => 'Tomato, mozzarella, and basil.',
            'price' => '11',
            'allergens' => ['gluten', 'lactose'],
        ]);

        $product8 = new Product([
            'name' => 'Cheeseburger',
            'description' => 'Beef patty, cheese, lettuce, and tomato.',
            'price' => '13.69',
            'allergens' => ['gluten', 'lactose'],
        ]);

        $product9 = new Product([
            'name' => 'Caesar Salad',
            'description' => 'Romaine lettuce, croutons, and Caesar dressing.',
            'price' => '8.3',
            'allergens' => ['egg', 'gluten'],
        ]);

        $product10 = new Product([
            'name' => 'Tacos de Pollo',
            'description' => 'Tortilla de maíz rellena de pollo asado, salsa picante y cebolla.',
            'price' => '9',
            'allergens' => ['gluten'],
        ]);

        $product11 = new Product([
            'name' => 'Sopa de Tomate',
            'description' => 'Sopa cremosa de tomate con un toque de albahaca fresca.',
            'price' => '7',
            'allergens' => ['lactosa'],
        ]);

        $product12 = new Product([
            'name' => 'Mazamorra',
            'description' => 'Crema de almendras con uvas cortadas por la mitad.',
            'price' => '6.66',
            'allergens' => ['lactosa'],
        ]);

        // Asociamos los productos si están presentes
        $menu1->products()->saveMany([$product1, $product2, $product3]);
        $menu2->products()->saveMany([$product4, $product5, $product6]);
        $menu3->products()->saveMany([$product7, $product8, $product9]);
        $menu4->products()->saveMany([$product10, $product11, $product12]);

        // Asociamos menus a admin 
        $admin->menus()->saveMany([$menu1, $menu2]);
        $admin2->menus()->save($menu3);
        $admin3->menus()->save($menu4);
    }
}
