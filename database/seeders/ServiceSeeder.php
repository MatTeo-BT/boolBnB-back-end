<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            'Wi-Fi',
            'posto macchina',
            'piscina',
            'portineria',
            'sauna',
            'vista mare',
            'vista montagna',
        ];

        foreach ($services as $servicesName) {
            $newServices = new Service();

            $newServices->name = $servicesName;
            $newServices->save();
        }
    }
}
