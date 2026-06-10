<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('room_types')->delete();

        $types = [
            ['title' => 'Single', 'description' => 'Single bed room suitable for one guest.', 'price' => 60.00, 'details' => null],
            ['title' => 'Double', 'description' => 'Double bed room suitable for two guests.', 'price' => 90.00, 'details' => null],
            ['title' => 'Twin', 'description' => 'Two single beds.', 'price' => 95.00, 'details' => null],
            ['title' => 'Deluxe', 'description' => 'Spacious room with additional amenities.', 'price' => 150.00, 'details' => null],
            ['title' => 'Suite', 'description' => 'Large suite with separate living area.', 'price' => 240.00, 'details' => null],
            ['title' => 'Family', 'description' => 'Room suitable for families.', 'price' => 180.00, 'details' => null],
        ];

        foreach ($types as $t) {
            DB::table('room_types')->insert(array_merge($t, ['created_at' => now(), 'updated_at' => now()]));
        }
    }
}
