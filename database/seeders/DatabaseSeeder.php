<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Departments ──────────────────────────────────────────
        $departments = [
            ['title' => 'Front Desk',       'detail' => 'Handles guest check-in, check-out, and inquiries.'],
            ['title' => 'Housekeeping',      'detail' => 'Responsible for cleaning and maintaining rooms.'],
            ['title' => 'Food & Beverage',   'detail' => 'Manages restaurant, bar, and room service.'],
            ['title' => 'Maintenance',       'detail' => 'Handles repairs and facility upkeep.'],
            ['title' => 'Security',          'detail' => 'Ensures safety of guests and property.'],
        ];
        if (DB::table('departments')->count() === 0) {
            DB::table('departments')->insert(array_map(fn($d) => [...$d, 'created_at' => now(), 'updated_at' => now()], $departments));
        }

        // ── Staff ────────────────────────────────────────────────
        $staff = [
            ['department_id' => 1, 'full_name' => 'James Anderson',  'bio' => 'Experienced front desk manager with 8 years in hospitality.',  'salary_type' => 'monthly', 'salary_amount' => 3200.00],
            ['department_id' => 1, 'full_name' => 'Sophia Williams',  'bio' => 'Friendly receptionist skilled in customer relations.',          'salary_type' => 'monthly', 'salary_amount' => 2400.00],
            ['department_id' => 2, 'full_name' => 'Maria Garcia',     'bio' => 'Detail-oriented housekeeper with 5 years experience.',         'salary_type' => 'daily',   'salary_amount' => 120.00],
            ['department_id' => 2, 'full_name' => 'Chen Wei',         'bio' => 'Supervises housekeeping staff and quality control.',           'salary_type' => 'monthly', 'salary_amount' => 2800.00],
            ['department_id' => 3, 'full_name' => 'Luca Rossi',       'bio' => 'Head chef specializing in Mediterranean cuisine.',             'salary_type' => 'monthly', 'salary_amount' => 4500.00],
            ['department_id' => 3, 'full_name' => 'Amina Hassan',     'bio' => 'Skilled bartender with mixology certification.',               'salary_type' => 'daily',   'salary_amount' => 150.00],
            ['department_id' => 4, 'full_name' => 'Robert Brown',     'bio' => 'Senior technician handling electrical and plumbing.',          'salary_type' => 'monthly', 'salary_amount' => 3000.00],
            ['department_id' => 5, 'full_name' => 'David Kimani',     'bio' => 'Security supervisor with law enforcement background.',         'salary_type' => 'monthly', 'salary_amount' => 2700.00],
        ];
        if (DB::table('staff')->count() === 0) {
            DB::table('staff')->insert(array_map(fn($s) => [...$s, 'photo' => null, 'created_at' => now(), 'updated_at' => now()], $staff));
        }

        // ── Room Types ───────────────────────────────────────────
        $roomTypes = [
            ['title' => 'Standard Room',    'description' => 'Comfortable room with essential amenities.',                         'price' => 89.00,  'details' => 'Queen bed, TV, Wi-Fi, private bathroom.'],
            ['title' => 'Deluxe Room',      'description' => 'Spacious room with premium furnishings and city view.',              'price' => 149.00, 'details' => 'King bed, minibar, smart TV, work desk, Wi-Fi.'],
            ['title' => 'Junior Suite',     'description' => 'Elegant suite with separate living area.',                           'price' => 229.00, 'details' => 'King bed, living area, jacuzzi, butler service.'],
            ['title' => 'Presidential Suite','description' => 'Luxurious top-floor suite with panoramic views.',                  'price' => 599.00, 'details' => '2 bedrooms, full kitchen, private terrace, concierge.'],
            ['title' => 'Twin Room',        'description' => 'Ideal for friends or colleagues travelling together.',               'price' => 109.00, 'details' => 'Two single beds, TV, Wi-Fi, private bathroom.'],
            ['title' => 'Family Room',      'description' => 'Large room designed for families with children.',                    'price' => 189.00, 'details' => 'King bed + bunk beds, extra bathroom, kitchenette.'],
        ];
        if (DB::table('room_types')->count() === 0) {
            DB::table('room_types')->insert(array_map(fn($r) => [...$r, 'created_at' => now(), 'updated_at' => now()], $roomTypes));
        }

        // ── Rooms ────────────────────────────────────────────────
        $rooms = [
            // Standard Rooms (type 1) — floor 1
            ['room_number' => '101', 'room_type_id' => 1, 'price' => 89.00],
            ['room_number' => '102', 'room_type_id' => 1, 'price' => 89.00],
            ['room_number' => '103', 'room_type_id' => 1, 'price' => 89.00],
            // Twin Rooms (type 5) — floor 1
            ['room_number' => '104', 'room_type_id' => 5, 'price' => 109.00],
            ['room_number' => '105', 'room_type_id' => 5, 'price' => 109.00],
            // Deluxe Rooms (type 2) — floor 2
            ['room_number' => '201', 'room_type_id' => 2, 'price' => 149.00],
            ['room_number' => '202', 'room_type_id' => 2, 'price' => 149.00],
            ['room_number' => '203', 'room_type_id' => 2, 'price' => 149.00],
            // Family Rooms (type 6) — floor 2
            ['room_number' => '204', 'room_type_id' => 6, 'price' => 189.00],
            ['room_number' => '205', 'room_type_id' => 6, 'price' => 189.00],
            // Junior Suites (type 3) — floor 3
            ['room_number' => '301', 'room_type_id' => 3, 'price' => 229.00],
            ['room_number' => '302', 'room_type_id' => 3, 'price' => 229.00],
            // Presidential Suite (type 4) — floor 4
            ['room_number' => '401', 'room_type_id' => 4, 'price' => 599.00],
        ];
        if (DB::table('rooms')->count() === 0) {
            DB::table('rooms')->insert(array_map(fn($r) => [...$r, 'created_at' => now(), 'updated_at' => now()], $rooms));
        }

        // ── Customers ────────────────────────────────────────────
        $customers = [
            ['first_name' => 'Oliver',   'last_name' => 'Smith',     'email' => 'oliver.smith@email.com',   'phone' => '+1-555-0101', 'address' => '12 Baker Street, London, UK'],
            ['first_name' => 'Emma',     'last_name' => 'Johnson',   'email' => 'emma.johnson@email.com',   'phone' => '+1-555-0102', 'address' => '45 Park Ave, New York, USA'],
            ['first_name' => 'Noah',     'last_name' => 'Williams',  'email' => 'noah.williams@email.com',  'phone' => '+1-555-0103', 'address' => '78 Queen St, Toronto, Canada'],
            ['first_name' => 'Ava',      'last_name' => 'Brown',     'email' => 'ava.brown@email.com',      'phone' => '+1-555-0104', 'address' => '23 Elm Road, Sydney, Australia'],
            ['first_name' => 'Liam',     'last_name' => 'Jones',     'email' => 'liam.jones@email.com',     'phone' => '+1-555-0105', 'address' => '5 Rue de Paris, Paris, France'],
            ['first_name' => 'Isabella', 'last_name' => 'Garcia',    'email' => 'isabella.garcia@email.com','phone' => '+1-555-0106', 'address' => '90 Calle Mayor, Madrid, Spain'],
            ['first_name' => 'Mason',    'last_name' => 'Martinez',  'email' => 'mason.martinez@email.com', 'phone' => '+1-555-0107', 'address' => '34 Via Roma, Rome, Italy'],
            ['first_name' => 'Mia',      'last_name' => 'Davis',     'email' => 'mia.davis@email.com',      'phone' => '+1-555-0108', 'address' => '67 King St, Dubai, UAE'],
            ['first_name' => 'Ethan',    'last_name' => 'Wilson',    'email' => 'ethan.wilson@email.com',   'phone' => '+1-555-0109', 'address' => '11 Sunset Blvd, Los Angeles, USA'],
            ['first_name' => 'Charlotte','last_name' => 'Taylor',    'email' => 'charlotte.taylor@email.com','phone'=> '+1-555-0110', 'address' => '88 High St, Edinburgh, UK'],
        ];
        if (DB::table('customers')->count() === 0) {
            DB::table('customers')->insert(array_map(fn($c) => [...$c, 'photo' => null, 'deleted_at' => null, 'created_at' => now(), 'updated_at' => now()], $customers));
        }

        // ── Bookings + Check-ins (demo) — inlined for reliability ──
        // Clear existing bookings
        DB::table('bookings')->delete();

        $today = \Carbon\Carbon::today();
        $typeIds = DB::table('room_types')->pluck('id')->toArray();
        $roomIds = DB::table('rooms')->pluck('id')->toArray();
        $bookings = [];
        for ($i = 0; $i < 25; $i++) {
            $start = $today->copy()->addDays(rand(-10, 20));
            $end = (clone $start)->addDays(rand(1,4));
            $status = rand(0,10) < 2 ? 'cancelled' : (rand(0,10) < 4 ? 'checked_in' : (rand(0,10) < 6 ? 'checked_out' : 'reserved'));
            $payment = $status === 'cancelled' ? 'refunded' : (rand(0,10) < 6 ? 'paid' : 'pending');
            $roomTypeId = empty($typeIds) ? null : $typeIds[array_rand($typeIds)];
            $roomId = (rand(0,1) && !empty($roomIds)) ? $roomIds[array_rand($roomIds)] : null;

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

        // Create check_ins for current checked_in bookings
        DB::table('check_ins')->delete();
        $checked = DB::table('bookings')->where('status','checked_in')->get();
        $roomIds = DB::table('rooms')->pluck('id')->toArray();
        foreach ($checked as $b) {
            $roomId = $b->room_id;
            if (empty($roomId) || !in_array($roomId, $roomIds)) {
                $roomId = !empty($roomIds) ? $roomIds[array_rand($roomIds)] : null;
            }

            DB::table('check_ins')->insert([
                'booking_id' => $b->id,
                'room_id' => $roomId,
                'staff_id' => 1,
                'checked_in_at' => $b->start_date . ' 14:00:00',
                'checked_out_at' => $b->end_date . ' 12:00:00',
                'status' => 'active',
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ── Admin User ───────────────────────────────────────────
        $this->call(AdminSeeder::class);
    }
}