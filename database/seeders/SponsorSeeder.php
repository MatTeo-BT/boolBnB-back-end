<?php

namespace Database\Seeders;

use App\Models\Sponsor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sponsors = [
            [
                'name' =>'Basic',
                'price'=> 2.99,
                'no_hours'=> 24
            ],
            [
                'name' =>'Plus',
                'price'=> 5.99,
                'no_hours'=> 72
            ],
            [
                'name' =>'Premium',
                'price'=> 14.99,
                'no_hours'=> 144
            ]
        ];

        foreach ($sponsors as $sponsor) {
            $newSponsor = new Sponsor();

            $newSponsor->name = $sponsor['name'];
            $newSponsor->price = $sponsor['price'];
            $newSponsor->no_hours = $sponsor['no_hours'];
            $newSponsor->save();
        }
    }
}
