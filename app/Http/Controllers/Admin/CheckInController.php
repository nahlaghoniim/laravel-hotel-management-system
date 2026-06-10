<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\CheckIn;
use App\Models\Room;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckInController extends Controller
{
    public function index(Request $request)
    {
        $checkinStats = [
            'active'    => CheckIn::where('status', 'active')->count(),
            'today'     => CheckIn::whereDate('checked_in_at', today())->count(),
            'completed' => CheckIn::where('status', 'completed')->count(),
        ];

        $checkins = CheckIn::with('booking.customer', 'room.roomType', 'staff')
            ->orderBy('checked_in_at', 'desc')
            ->paginate(20);

        return view('admin.checkins.index', compact('checkins', 'checkinStats'));
    }

    public function create(Request $request)
    {
        // Only show reserved bookings — a checked_in booking without an
        // activeCheckIn is a data integrity problem, not a valid candidate.
        $bookings = Booking::with('customer', 'room', 'roomType')
            ->where('status', 'reserved')
            ->whereDoesntHave('activeCheckIn')
            ->orderBy('start_date')
            ->get();

        $rooms  = Room::with('roomType')->orderBy('room_number')->get();
        $staff  = Staff::orderBy('full_name')->get();

        $selectedBooking = $request->filled('booking_id')
            ? Booking::with('customer', 'room', 'roomType')->find($request->integer('booking_id'))
            : null;

        return view('admin.checkins.create', compact('bookings', 'rooms', 'staff', 'selectedBooking'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'booking_id'    => ['required', 'exists:bookings,id'],
            'room_id'       => ['required', 'exists:rooms,id'],
            'staff_id'      => ['nullable', 'exists:staff,id'],
            'checked_in_at' => ['nullable', 'date'],
            'notes'         => ['nullable', 'string', 'max:2000'],
        ]);

        $checkedInAt = $request->filled('checked_in_at')
            ? Carbon::parse($data['checked_in_at'])
            : now();

        DB::transaction(function () use ($data, $checkedInAt) {
            // Lock both the booking and any existing check-in rows together
            // so concurrent requests can't both pass the duplicate check.
            $booking = Booking::lockForUpdate()->findOrFail($data['booking_id']);

            if ($booking->status !== 'reserved') {
                throw ValidationException::withMessages([
                    'booking_id' => 'Only reserved bookings can be checked in.',
                ]);
            }

            $hasActiveCheckIn = CheckIn::where('booking_id', $booking->id)
                ->where('status', 'active')
                ->lockForUpdate()
                ->exists();

            if ($hasActiveCheckIn) {
                throw ValidationException::withMessages([
                    'booking_id' => 'This booking already has an active check-in.',
                ]);
            }

            CheckIn::create([
                'booking_id'    => $booking->id,
                'room_id'       => $data['room_id'],
                'staff_id'      => $data['staff_id'] ?? null,
                'checked_in_at' => $checkedInAt,
                'status'        => 'active',
                'notes'         => $data['notes'] ?? null,
            ]);

            $booking->update([
                'room_id'       => $data['room_id'],
                'status'        => 'checked_in',
                'checked_in_at' => $checkedInAt,
            ]);
        });

        return redirect()
            ->route('checkins.index')
            ->with('success', 'Guest checked in successfully.');
    }
}