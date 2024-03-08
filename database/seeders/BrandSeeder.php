<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            'AMS',
            'Brother',
            'BULLMER',
            'Dino',
            'Eastman',
            'Gemsy',
            'Hashima',
            'Juki'
        ];

        foreach ($brands as $brand) {
            \App\Models\Brand::create([
                'name' => $brand
            ]);
        }
    }
}