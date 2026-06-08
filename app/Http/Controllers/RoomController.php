<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomType;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('roomType')->get();

        return view('admin.room.index', compact('rooms'));
    }

    public function create()
    {
        $roomTypes = RoomType::all();

        return view('admin.room.create', compact('roomTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|string|max:255',
            'room_type_id' => 'required|exists:room_types,id',
            'price' => 'required|numeric|min:0',
        ]);

        Room::create($request->only([
            'room_number',
            'room_type_id',
            'price'
        ]));

        return redirect()->route('rooms.index')
            ->with('success', 'Room created successfully.');
    }

    public function show(string $id)
    {
        $room = Room::with('roomType')->findOrFail($id);

        return view('admin.room.show', compact('room'));
    }

    public function edit(string $id)
    {
        $room = Room::findOrFail($id);
        $roomTypes = RoomType::all();

        return view('admin.room.edit', compact('room', 'roomTypes'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'room_number' => 'required|string|max:255',
            'room_type_id' => 'required|exists:room_types,id',
            'price' => 'required|numeric|min:0',
        ]);

        $room = Room::findOrFail($id);

        $room->update($request->only([
            'room_number',
            'room_type_id',
            'price'
        ]));

        return redirect()->route('rooms.index')
            ->with('success', 'Room updated successfully.');
    }

    public function destroy(string $id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return redirect()->route('rooms.index')
            ->with('success', 'Room deleted successfully.');
    }
}