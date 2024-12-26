<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Frame;
use App\Models\Material;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
         User::factory(1)->create();

         Brand::factory(3)->create();
         Material::factory(3)->create();
         Supplier::factory(3)->create();
         Frame::factory(100)->create();
    }
}
