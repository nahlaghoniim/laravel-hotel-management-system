<?php

namespace App\Http\Controllers;

use App\Models\Roomtype;
use App\Models\RoomtypeImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomtypeController extends Controller
{
   public function index()
{
    $roomtypes = Roomtype::with(['coverImage'])
                         ->withCount('images')
                         ->latest()
                         ->get();

    return view('admin.roomtype.index', compact('roomtypes'));
}

    public function create()
    {
        return view('admin.roomtype.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'details'     => 'nullable|string',
            'images'      => 'nullable|array',
            'images.*'    => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $roomtype = Roomtype::create($request->only('title', 'price', 'description', 'details'));

        $this->handleImageUploads($request, $roomtype);

        return redirect()->route('roomtypes.index')
                         ->with('success', 'Room type created successfully.');
    }

    public function show(Roomtype $roomtype)
    {
        $roomtype->load('images');
        return view('admin.roomtype.show', compact('roomtype'));
    }

    public function edit(Roomtype $roomtype)
    {
        $roomtype->load('images');
        return view('admin.roomtype.edit', compact('roomtype'));
    }

    public function update(Request $request, Roomtype $roomtype)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'price'            => 'required|numeric|min:0',
            'description'      => 'nullable|string',
            'details'          => 'nullable|string',
            'images'           => 'nullable|array',
            'images.*'         => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'delete_images'    => 'nullable|array',
            'delete_images.*'  => 'integer|exists:roomtype_images,id',
        ]);

        $roomtype->update($request->only('title', 'price', 'description', 'details'));

        if ($request->has('delete_images')) {
            $toDelete = RoomtypeImage::whereIn('id', $request->delete_images)
                                     ->where('room_type_id', $roomtype->id)
                                     ->get();
            foreach ($toDelete as $img) {
                Storage::disk('public')->delete($img->image_path);
                $img->delete();
            }
        }

        $this->handleImageUploads($request, $roomtype);

        return redirect()->route('roomtypes.index')
                         ->with('success', 'Room type updated successfully.');
    }

    public function destroy(Roomtype $roomtype)
    {
        foreach ($roomtype->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }

        $roomtype->delete();

        return redirect()->route('roomtypes.index')
                         ->with('success', 'Room type deleted.');
    }

    private function handleImageUploads(Request $request, Roomtype $roomtype): void
    {
        if (!$request->hasFile('images')) return;

        $order = $roomtype->images()->max('sort_order') ?? 0;

        foreach ($request->file('images') as $file) {
            $path = $file->store('roomtypes', 'public');
            $roomtype->images()->create([
                'image_path' => $path,
                'sort_order' => ++$order,
            ]);
        }
    }
}