<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Passenger;

class PassengerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Passenger::truncate();

        Passenger::create(["name" => "Amit", "phone" => "9999999999"]);
        Passenger::create(["name" => "Rahul", "phone" => "8888888888"]);
    }
}
