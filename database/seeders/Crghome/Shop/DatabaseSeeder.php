<?php

namespace Database\Seeders\Crghome\Shop;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(CategoryProductSeeder::class);

        if(env('APP_ENV') == 'local'){
            //\App\Models\User::factory(25)->create();
            //foreach(User::all() AS $user){
            //    $user->assignRole($role_registered);
            //};

            // \App\Models\Category::factory(15)->create();
            // \App\Models\CategoryContent::factory(30)->create();
            // \App\Models\Article::factory(8)->create();
            // \App\Models\ArticleContent::factory(8)->create();
        }

        //Model::reguard();
    }
}
