<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Marco',
            'surname' => 'Rossi',
            'date_of_birth' => '1998-04-19',
            'email' => 'marcorossi@gmail.com',
            'password' => Hash::make('password'),
            'address' => 'Via Roma 57',

            
        ]);
        User::create([
            'name' => 'Fra',
            'surname' => 'Blu',
            'date_of_birth' => '1998-04-19',
            'email' => 'a@gmail.com',
            'password' => Hash::make('aaa'),
            'address' => 'Via Mia 57',

            
        ]);
        User::create([
            'name' => 'Franco',
            'surname' => 'Giallo',
            'date_of_birth' => '1998-04-19',
            'email' => 'aa@gmail.com',
            'password' => Hash::make('aaa'),
            'address' => 'Via Mia 57',

            
        ]);
        User::create([
            'name' => 'Paolo',
            'surname' => 'Cannone',
            'date_of_birth' => '1998-04-19',
            'email' => 'aaa@gmail.com',
            'password' => Hash::make('aaa'),
            'address' => 'Via Mia 57',

            
        ]);
    }
}