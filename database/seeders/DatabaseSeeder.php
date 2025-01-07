<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Agreement;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Frame;
use App\Models\Material;
use App\Models\Service;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        User::factory(1)->create(); // não remover

        Brand::factory()->count(4)->create(); // não remover
        Material::factory()->count(3)->create(); // não remover

        Supplier::factory(3)->create();

        Frame::factory(100)->create();
        Service::factory(20)->create();

        Agreement::factory()->count(4)->create();
        Customer::factory()->count(100)->create();
        Address::factory(100)->create();
    }
}
