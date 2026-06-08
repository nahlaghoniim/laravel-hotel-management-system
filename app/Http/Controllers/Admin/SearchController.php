<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->input('q', ''));

        $bookings = Booking::with('customer', 'room', 'roomType')
            ->when($query !== '', function ($q) use ($query) {
                $q->where(function ($q) use ($query) {
                    if (is_numeric($query)) {
                        $q->where('id', $query);
                    }

                    $q->orWhere('status', 'like', "%{$query}%")
                        ->orWhere('payment_status', 'like', "%{$query}%")
                        ->orWhereHas('customer', function ($q) use ($query) {
                            $q->where('first_name', 'like', "%{$query}%")
                                ->orWhere('last_name', 'like', "%{$query}%")
                                ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ["%{$query}%"])
                                ->orWhere('email', 'like', "%{$query}%");
                        })
                        ->orWhereHas('room', function ($q) use ($query) {
                            $q->where('room_number', 'like', "%{$query}%");
                        })
                        ->orWhereHas('roomType', function ($q) use ($query) {
                            $q->where('title', 'like', "%{$query}%");
                        });
                });
            }, function ($q) {
                $q->whereRaw('0 = 1');
            })
            ->orderBy('start_date', 'desc')
            ->paginate(15)
            ->appends(['q' => $query]);

        return view('admin.search.index', compact('query', 'bookings'));
    }
}
