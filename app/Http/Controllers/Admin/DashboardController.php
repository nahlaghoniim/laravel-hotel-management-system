<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Staff;
use App\Models\Booking;
use App\Models\CheckIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard with basic metrics.
     */
    public function index(Request $request)
    {
        $today = Carbon::today();
        $filter = $request->query('filter', 'today');
        $periodStart = $today->copy();
        $periodEnd = $today->copy();
        $periodLabel = 'Today';

        if ($filter === 'this_week') {
            $periodStart = $today->copy()->startOfWeek();
            $periodEnd = $today->copy()->endOfWeek();
            $periodLabel = 'This Week';
        } elseif ($filter === 'this_month') {
            $periodStart = $today->copy()->startOfMonth();
            $periodEnd = $today->copy()->endOfMonth();
            $periodLabel = 'This Month';
        } elseif ($filter === 'custom' && $request->filled('start') && $request->filled('end')) {
            try {
                $periodStart = Carbon::parse($request->input('start'))->startOfDay();
                $periodEnd = Carbon::parse($request->input('end'))->endOfDay();
                if ($periodStart->greaterThan($periodEnd)) {
                    [$periodStart, $periodEnd] = [$periodEnd, $periodStart];
                }
                $periodLabel = $periodStart->format('M j') . ' – ' . $periodEnd->format('M j');
            } catch (\Exception $e) {
                $filter = 'today';
            }
        }

        $roomCount = Room::count();
        $roomTypeCount = RoomType::count();
        $customerCount = Customer::count();
        $departmentCount = Department::count();
        $staffCount = Staff::count();

        $roomStatusCounts = Room::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $occupiedRooms = $roomStatusCounts['occupied'] ?? Booking::where('status', 'checked_in')
            ->orWhere(function ($q) use ($today) {
                $q->where('status', '!=', 'cancelled')
                    ->whereDate('start_date', '<=', $today)
                    ->whereDate('end_date', '>=', $today);
            })->count();

        $reservedRooms = $roomStatusCounts['reserved'] ?? 0;
        $outOfServiceRooms = $roomStatusCounts['out_of_service'] ?? 0;
        $maintenanceRooms = $roomStatusCounts['maintenance'] ?? 0;
        $cleaningRooms = $roomStatusCounts['cleaning'] ?? 0;
        $availableRooms = $roomStatusCounts['available'] ?? max(0, $roomCount - ($occupiedRooms + $reservedRooms + $outOfServiceRooms + $maintenanceRooms + $cleaningRooms));
        $occupancyRate = $roomCount ? round(($occupiedRooms / $roomCount) * 100, 1) : 0;

        $checkedInCount = Booking::where('status', 'checked_in')->count();
        $checkedOutToday = Booking::whereDate('end_date', $today)->where('status', 'checked_out')->count();

        $arrivals = Booking::where('status', 'reserved')
            ->whereBetween('start_date', [$today, $today->copy()->addDays(7)])
            ->orderBy('start_date')
            ->with('customer','room','roomType')
            ->limit(10)
            ->get();

        $departures = Booking::where(function ($q) use ($today) {
                $q->where('status', 'checked_in')
                  ->orWhere('status', '!=', 'cancelled');
            })
            ->whereBetween('end_date', [$today, $today->copy()->addDays(7)])
            ->orderBy('end_date')
            ->with('customer','room','roomType')
            ->limit(10)
            ->get();

        $todaysRevenue = Booking::whereDate('start_date', $today)
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        $averageDailyRate = Booking::where('payment_status','paid')
            ->whereRaw('datediff(end_date, start_date) > 0')
            ->select(DB::raw('avg(total_amount / datediff(end_date,start_date)) as adr'))
            ->value('adr') ?? 0;

        $revpar = $roomCount > 0
            ? round(Booking::where('payment_status','paid')
                ->whereBetween('start_date', [$today->copy()->subDays(30), $today])
                ->sum('total_amount') / ($roomCount * 30), 2)
            : 0;

        $year = $today->year;
        $monthlyRevenue = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyRevenue[] = Booking::whereYear('start_date', $year)
                ->whereMonth('start_date', $m)
                ->where('payment_status','paid')
                ->sum('total_amount');
        }

        $roomTypeRevenue = DB::table('bookings')
            ->join('room_types', 'bookings.room_type_id', '=', 'room_types.id')
            ->select('room_types.title', DB::raw('SUM(bookings.total_amount) as total'))
            ->whereYear('bookings.start_date', $year)
            ->where('bookings.payment_status', 'paid')
            ->groupBy('room_types.title')
            ->get();

        $roomTypeLabels = $roomTypeRevenue->pluck('title');
        $roomTypeData = $roomTypeRevenue->pluck('total');

        $bookingStatus = Booking::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total','status')
            ->toArray();

        $statusLabels = array_keys($bookingStatus);
        $statusData = array_values($bookingStatus);

        $roomStatusLabels = ['Available','Occupied','Reserved','Maintenance','Cleaning','Out of Service'];
        $roomStatusData = [
            $roomStatusCounts['available'] ?? 0,
            $roomStatusCounts['occupied'] ?? 0,
            $roomStatusCounts['reserved'] ?? 0,
            $roomStatusCounts['maintenance'] ?? 0,
            $roomStatusCounts['cleaning'] ?? 0,
            $roomStatusCounts['out_of_service'] ?? 0,
        ];

        $trendDays = 12;
        $occupancyTrendLabels = [];
        $occupancyTrendData = [];
        for ($i = $trendDays - 1; $i >= 0; $i--) {
            $day = $today->copy()->subDays($i);
            $occupancyTrendLabels[] = $day->format('M j');
            $occupancyTrendData[] = Booking::where('status','!=','cancelled')
                ->whereDate('start_date', '<=', $day)
                ->whereDate('end_date', '>=', $day)
                ->count();
        }

        $bookingsCreated = Booking::whereBetween('created_at', [$periodStart, $periodEnd])->count();
        $bookingsCancelled = Booking::whereBetween('created_at', [$periodStart, $periodEnd])
            ->where('status', 'cancelled')
            ->count();
        $bookingConversion = $bookingsCreated ? round((($bookingsCreated - $bookingsCancelled) / $bookingsCreated) * 100, 1) : 0;

        $periodRevenue = Booking::whereBetween('start_date', [$periodStart, $periodEnd])
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        $periodDays = max(1, $periodStart->diffInDays($periodEnd) + 1);
        $previousPeriodEnd = $periodStart->copy()->subDay();
        $previousPeriodStart = $previousPeriodEnd->copy()->subDays($periodDays - 1);
        $previousRevenue = Booking::whereBetween('start_date', [$previousPeriodStart, $previousPeriodEnd])
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        $revenueChange = $previousRevenue > 0
            ? round((($periodRevenue - $previousRevenue) / $previousRevenue) * 100, 1)
            : ($periodRevenue > 0 ? 100 : 0);

        $revenueChangeLabel = $revenueChange >= 0 ? 'up' : 'down';

        $arrivalsToday = Booking::whereDate('start_date', $today)
            ->where('status', 'reserved')
            ->count();

        $checkoutToday = Booking::whereDate('end_date', $today)
            ->where('status', 'checked_in')
            ->count();

        $overduePayments = Booking::where('payment_status', 'pending')
            ->whereDate('start_date', '<=', $today)
            ->where('status', '!=', 'cancelled')
            ->count();

        $maintenanceAlerts = $maintenanceRooms;
        $roomsAwaitingCleaning = $cleaningRooms;
        $roomsCleanedToday = Booking::whereDate('checked_out_at', $today)->count();
        $roomsUnderMaintenance = $maintenanceRooms;

        $recentCheckins = CheckIn::with('booking.customer', 'room.roomType')
            ->where('status', 'active')
            ->orderBy('checked_in_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'roomCount',
            'roomTypeCount',
            'customerCount',
            'departmentCount',
            'staffCount',
            'occupiedRooms',
            'availableRooms',
            'reservedRooms',
            'outOfServiceRooms',
            'maintenanceRooms',
            'cleaningRooms',
            'occupancyRate',
            'checkedInCount',
            'checkedOutToday',
            'averageDailyRate',
            'revpar',
            'arrivals',
            'departures',
            'todaysRevenue',
            'monthlyRevenue',
            'roomTypeLabels',
            'roomTypeData',
            'statusLabels',
            'statusData',
            'occupancyTrendLabels',
            'occupancyTrendData',
            'recentCheckins',
            'filter',
            'roomStatusLabels',
            'roomStatusData',
            'periodLabel',
            'arrivalsToday',
            'checkoutToday',
            'overduePayments',
            'maintenanceAlerts',
            'roomsAwaitingCleaning',
            'roomsCleanedToday',
            'roomsUnderMaintenance',
            'bookingsCreated',
            'bookingsCancelled',
            'bookingConversion',
            'periodRevenue',
            'revenueChange',
            'revenueChangeLabel',
            'periodStart',
            'periodEnd'
        ));
    }

    public function report(Request $request)
    {
        $today = Carbon::today();

        $arrivals = Booking::where('status', 'reserved')
            ->whereBetween('start_date', [$today, $today->copy()->addDays(7)])
            ->orderBy('start_date')
            ->with('customer','room','roomType')
            ->get();

        $departures = Booking::where(function($q) use ($today){
                $q->where('status','checked_in')
                  ->orWhere('status','!=','cancelled');
            })
            ->whereBetween('end_date', [$today, $today->copy()->addDays(7)])
            ->orderBy('end_date')
            ->with('customer','room','roomType')
            ->get();

        $filename = 'dashboard-report-' . $today->format('Ymd') . '.csv';

        $callback = function () use ($today, $arrivals, $departures) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Hotel Dashboard Report', $today->format('Y-m-d')]);
            fputcsv($handle, []);
            fputcsv($handle, ['Metric', 'Value']);
            fputcsv($handle, ['Total Rooms', Room::count()]);
            fputcsv($handle, ['Room Types', RoomType::count()]);
            fputcsv($handle, ['Customers', Customer::count()]);
            fputcsv($handle, ['Departments', Department::count()]);
            fputcsv($handle, ['Staff', Staff::count()]);
            fputcsv($handle, ['Occupied Rooms', Booking::where('status', 'checked_in')->orWhere(function ($q) use ($today) {
                $q->where('status', '!=', 'cancelled')
                    ->whereDate('start_date', '<=', $today)
                    ->whereDate('end_date', '>=', $today);
            })->count()]);
            fputcsv($handle, ['Available Rooms', max(0, Room::count() - Booking::where('status', 'checked_in')->orWhere(function ($q) use ($today) {
                $q->where('status', '!=', 'cancelled')
                    ->whereDate('start_date', '<=', $today)
                    ->whereDate('end_date', '>=', $today);
            })->count())]);
            fputcsv($handle, ['Occupancy Rate', ($today->isToday() && Room::count()) ? round((Booking::where('status', 'checked_in')->orWhere(function ($q) use ($today) {
                $q->where('status', '!=', 'cancelled')
                    ->whereDate('start_date', '<=', $today)
                    ->whereDate('end_date', '>=', $today);
            })->count() / Room::count()) * 100, 1) . '%': '0%']);
            fputcsv($handle, ['Revenue Today', number_format(Booking::whereDate('start_date', $today)->where('payment_status', 'paid')->sum('total_amount'), 2)]);
            fputcsv($handle, ['RevPAR', '$' . number_format($today->isToday() && Room::count() ? round(Booking::where('payment_status','paid')->whereBetween('start_date', [$today->copy()->subDays(30), $today])->sum('total_amount') / (Room::count() * 30), 2) : 0, 2)]);
            fputcsv($handle, ['Upcoming Arrivals (7d)', $arrivals->count()]);
            fputcsv($handle, ['Upcoming Departures (7d)', $departures->count()]);
            fputcsv($handle, ['Maintenance Alerts', Booking::where('status', '!=', 'cancelled')->whereHas('room', function ($q) {
                $q->where('status', 'maintenance');
            })->count()]);
            fputcsv($handle, ['Overdue Payments', Booking::where('payment_status', 'pending')->whereDate('start_date', '<=', $today)->where('status', '!=', 'cancelled')->count()]);
            fputcsv($handle, []);

            fputcsv($handle, ['Upcoming Arrivals']);
            fputcsv($handle, ['Guest', 'Room', 'Start Date', 'End Date', 'Total']);
            foreach ($arrivals as $booking) {
                fputcsv($handle, [
                    trim(($booking->customer->first_name ?? '') . ' ' . ($booking->customer->last_name ?? '')) ?: 'Guest',
                    $booking->room->room_number ?? ($booking->roomType->title ?? 'Unassigned'),
                    $booking->start_date->format('Y-m-d'),
                    $booking->end_date->format('Y-m-d'),
                    number_format($booking->total_amount, 2),
                ]);
            }

            fputcsv($handle, []);
            fputcsv($handle, ['Upcoming Departures']);
            fputcsv($handle, ['Guest', 'Room', 'Start Date', 'End Date', 'Total']);
            foreach ($departures as $booking) {
                fputcsv($handle, [
                    trim(($booking->customer->first_name ?? '') . ' ' . ($booking->customer->last_name ?? '')) ?: 'Guest',
                    $booking->room->room_number ?? ($booking->roomType->title ?? 'Unassigned'),
                    $booking->start_date->format('Y-m-d'),
                    $booking->end_date->format('Y-m-d'),
                    number_format($booking->total_amount, 2),
                ]);
            }

            fclose($handle);
        };

        return Response::streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
