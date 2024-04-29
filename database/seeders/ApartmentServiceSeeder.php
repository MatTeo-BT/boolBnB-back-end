<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Generator as Faker;

class ApartmentServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $apartments = Apartment::all();
        $services = Service::all()->pluck('id');

        foreach ($apartments as $apartment) {
            $apartment->services()->sync($faker->randomElements( $services, rand(1,4), false ));
        }
    
        
    }
    
}
