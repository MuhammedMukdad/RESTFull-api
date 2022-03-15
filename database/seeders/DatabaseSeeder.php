<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        User::truncate();
        Category::truncate();
        Product::truncate();
        Transactions::truncate();
        DB::table('category_product')->truncate();

        $usersQuantity=1000;
        $categoriesQuantity=30;
        $productsQuantity=1000;
        $transactionsQuantity=1000;

       User::factory()->count($usersQuantity)->create();

       Category::factory()->count($categoriesQuantity)->create();

       Product::factory()->count($productsQuantity)->create()->each(function($product){
        $categories=Category::all()->random(mt_rand(1,5))->pluck('id');
        $product->categories()->attach($categories);
       });

       Transactions::factory()->count($transactionsQuantity)->create();

    }
}
