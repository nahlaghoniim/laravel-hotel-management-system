<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomType;

class RoomtypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
$roomtypes = RoomType::all();

    return view(
        'admin.roomtype.index',
        compact('roomtypes')
    );    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roomtype.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        RoomType::create(
            $request->only(['title', 'description'])
        );

        return redirect()
            ->route('roomtypes.index')
            ->with('success', 'Room type created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $roomtype = RoomType::findOrFail($id);

        return view('admin.roomtype.show', compact('roomtype'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $roomtype = RoomType::findOrFail($id);

        return view('admin.roomtype.edit', compact('roomtype'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $roomtype = RoomType::findOrFail($id);

        $roomtype->update(
            $request->only(['title', 'description'])
        );

        return redirect()
            ->route('roomtypes.index')
            ->with('success', 'Room type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $roomtype = RoomType::findOrFail($id);

        $roomtype->delete();

        return redirect()
            ->route('roomtypes.index')
            ->with('success', 'Room type deleted successfully.');
    }
}