<?php

namespace Database\Seeders\Services;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            ['name' => 'Plumbing', 'description' => 'Plumbing services', 'price' => 500, 'status' => 1],
            ['name' => 'Electrical Repair', 'description' => 'Electrical repair services' , 'price' => 800, 'status' => 1],
            ['name' => 'AC Maintenance', 'description' => 'AC maintenance services' , 'price' => 1200, 'status' => 1],
            ['name' => 'Cleaning', 'description' => 'Cleaning services' , 'price' => 300, 'status' => 1],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
