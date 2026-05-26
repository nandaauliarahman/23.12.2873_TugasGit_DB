<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        for ($i = 1; $i <= 5; $i++) {
            DB::table('partners')->insert([
                'name' => $faker->company(),
                'logo_url' => 'https://placehold.co/200x200?text=Partner+'.$i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}