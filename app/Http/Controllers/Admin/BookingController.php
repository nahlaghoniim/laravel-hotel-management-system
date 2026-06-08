<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $bookingStats = [
            'total' => Booking::count(),
            'reserved' => Booking::where('status', 'reserved')->count(),
            'checked_in' => Booking::where('status', 'checked_in')->count(),
            'pending_payment' => Booking::where('payment_status', 'pending')->count(),
        ];

        $bookings = Booking::with('customer','room','roomType','activeCheckIn')->orderBy('start_date','desc')->paginate(20);
        return view('admin.bookings.index', compact('bookings', 'bookingStats'));
    }

    public function create()
    {
        $customers = Customer::orderBy('last_name')->get();
        $roomTypes = RoomType::orderBy('title')->get();
        $availableRooms = Room::where('status', Room::STATUS_AVAILABLE)
            ->orderBy('room_number')
            ->get();

        return view('admin.bookings.create', compact('customers', 'roomTypes', 'availableRooms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'room_type_id' => ['required', 'exists:room_types,id'],
            'room_id' => ['nullable', 'exists:rooms,id'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'adults' => ['required', 'integer', 'min:1'],
            'children' => ['required', 'integer', 'min:0'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:8'],
            'payment_status' => ['required', 'in:pending,paid,refunded'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($data) {
            $booking = Booking::create(array_merge($data, [
                'status' => 'reserved',
            ]));

            if (! empty($data['room_id'])) {
                Room::where('id', $data['room_id'])
                    ->update(['status' => Room::STATUS_RESERVED]);
            }
        });

        return redirect()->route('bookings.index')
            ->with('success', 'Booking created successfully.');
    }

    public function show(Booking $booking)
    {
        $booking->load('customer','room','roomType','activeCheckIn.staff');
        return view('admin.bookings.show', compact('booking'));
    }

    public function checkoutForm(Booking $booking)
    {
        if (! $booking->can_checkout) {
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'This booking is not eligible for checkout.');
        }

        $booking->load('customer','room','roomType','activeCheckIn.staff');

        return view('admin.bookings.checkout', compact('booking'));
    }

    public function checkout(Request $request, Booking $booking)
    {
        if (! $booking->can_checkout) {
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'This booking cannot be checked out.');
        }

        $data = $request->validate([
            'payment_status' => ['required', 'in:paid,pending,refunded'],
            'checkout_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($booking, $data) {
            $booking->checkout($data);
        });

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Guest checkout completed successfully.');
    }
}
