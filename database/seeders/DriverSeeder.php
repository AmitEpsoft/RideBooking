<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Driver;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Driver::truncate();

        Driver::create(["name" => "Driver One", "phone" => "7777777777"]);
        Driver::create(["name" => "Driver Two", "phone" => "6666666666"]);
    }
}
