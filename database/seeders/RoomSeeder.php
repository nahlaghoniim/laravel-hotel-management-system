<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('rooms')->delete();


        $types = DB::table('room_types')->pluck('id')->toArray();
        if (empty($types)) {
            return; // nothing to attach rooms to
        }

        $rooms = [];
        $total = 25;
        for ($i = 1; $i <= $total; $i++) {
            $rooms[] = [
                'room_number' => (string) (100 + $i),
                'room_type_id' => $types[array_rand($types)],
                'price' => rand(50, 400),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach ($rooms as $r) {
            DB::table('rooms')->insert($r);
        }
    }
}
