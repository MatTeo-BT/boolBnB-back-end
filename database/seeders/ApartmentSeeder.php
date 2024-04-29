<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apartments = config("db.apartments");

        foreach ($apartments as $apartment) {
            $newApartment = new Apartment();
            isset($apartment['user_id']) ? $newApartment->user_id = $apartment['user_id'] : $newApartment->user_id = NULL;
            $newApartment->title = $apartment['title'];
            $newApartment->no_rooms = $apartment['no_rooms'];
            $newApartment->no_beds = $apartment['no_beds'];
            $newApartment->no_bathrooms = $apartment['no_bathrooms'];
            $newApartment->square_meters = $apartment['square_meters'];
            $newApartment->address = $apartment['address'];
            $newApartment->img = $apartment['img'];
            $newApartment->visible = $apartment['visible'];
            $newApartment->latitude = $apartment['latitude'];
            $newApartment->longitude = $apartment['longitude'];
            $newApartment->price = $apartment['price'];
            $newApartment->description = $apartment['description'];
            $newApartment->save();


        }
    }
}
