<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MachineTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $machineTypes = [
            'Lockstitch',
            'Overlock',
            'Interlock',
            'Button Hole',
            'Button Stitch',
            'Bar Tack',
            'Feed of the Arm',
            'Flat Lock',
            'Kansai Special',
            'Multi Needle Chain Stitch',
            'Single Needle Chain Stitch',
            'Zig Zag',
            'Blind Stitch',
            'Cover Stitch',
            'Bartack',
            'Button Sewer',
            'Feed Off The Arm',
            'Flatlock',
            'Hemmer',
            'Interlock',
            'Overlock',
            'Pocket Welt',
            'Post Bed',
            'Roll Hem',
            'Safety Stitch',
            'Single Needle Chain Stitch',
            'Single Needle Lock Stitch',
            'Single Needle Post Bed',
            'Single Needle Zig Zag',
            'Twin Needle Chain Stitch',
            'Twin Needle Lock Stitch',
            'Twin Needle Post Bed',
            'Twin Needle Zig Zag',
            'Zig Zag'
        ];

        foreach ($machineTypes as $machineType) {
            \App\Models\MachineType::create([
                'name' => $machineType
            ]);
        }
    }
}