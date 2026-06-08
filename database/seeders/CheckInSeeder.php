<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CheckInSeeder extends Seeder
{
    public function run(): void
    {
        $today = Carbon::today();

        // Reset check_ins
        DB::table('check_ins')->delete();

        $bookings = DB::table('bookings')->where('status', 'checked_in')->get();
        foreach ($bookings as $b) {
            DB::table('check_ins')->insert([
                'booking_id' => $b->id,
                'room_id' => $b->room_id ?? 1,
                'staff_id' => 1,
                'checked_in_at' => $b->start_date . ' 14:00:00',
                'checked_out_at' => $b->end_date . ' 12:00:00',
                'status' => 'active',
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
