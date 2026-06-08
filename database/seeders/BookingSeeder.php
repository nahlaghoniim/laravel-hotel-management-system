<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $today = Carbon::today();

        // Reset bookings for a clean demo seed
        DB::table('bookings')->delete();

        $bookings = [];
        // create 25 bookings spread across the month with mixed status
        for ($i = 0; $i < 25; $i++) {
            $start = $today->copy()->addDays(rand(-10, 20));
            $end = (clone $start)->addDays(rand(1,4));
            $status = rand(0,10) < 2 ? 'cancelled' : (rand(0,10) < 4 ? 'checked_in' : (rand(0,10) < 6 ? 'checked_out' : 'reserved'));
            $payment = $status === 'cancelled' ? 'refunded' : (rand(0,10) < 6 ? 'paid' : 'pending');
            $roomTypeId = rand(1,6);
            $roomId = (rand(0,1) ? rand(1,13) : null);

            $bookings[] = [
                'customer_id' => rand(1,10),
                'room_id' => $roomId,
                'room_type_id' => $roomTypeId,
                'start_date' => $start->toDateString(),
                'end_date' => $end->toDateString(),
                'status' => $status,
                'payment_status' => $payment,
                'total_amount' => rand(80,600),
                'currency' => 'USD',
                'adults' => rand(1,3),
                'children' => rand(0,2),
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach ($bookings as $b) {
            DB::table('bookings')->insert($b);
        }
    }
}
