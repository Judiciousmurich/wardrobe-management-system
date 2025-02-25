<?php

namespace App\Http\Controllers;

use App\Models\ClothingItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClothingItemController extends Controller
{
    // Get all clothing items for the authenticated user
    public function index(Request $request)
    {
        $items = ClothingItem::where('user_id', $request->user()->id)->get();
        return response()->json($items);
    }

    // Store a new clothing item
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'color' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('clothing_images', 'public');
        }

        $item = ClothingItem::create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'category' => $request->category,
            'color' => $request->color,
            'size' => $request->size,
            'brand' => $request->brand,
            'purchase_date' => $request->purchase_date,
            'notes' => $request->notes,
            'image_path' => $imagePath,
        ]);

        return response()->json([
            'message' => 'Clothing item created successfully',
            'item' => $item
        ], 201);
    }

    // Get a specific clothing item
    public function show(Request $request, $id)
    {
        $item = ClothingItem::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();
            
        return response()->json($item);
    }

    // Update a clothing item
    public function update(Request $request, $id)
    {
        $item = ClothingItem::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'color' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($item->image_path) {
                Storage::disk('public')->delete($item->image_path);
            }
            $imagePath = $request->file('image')->store('clothing_images', 'public');
            $item->image_path = $imagePath;
        }

        $item->name = $request->name;
        $item->category = $request->category;
        $item->color = $request->color;
        $item->size = $request->size;
        $item->brand = $request->brand;
        $item->purchase_date = $request->purchase_date;
        $item->notes = $request->notes;
        $item->save();

        return response()->json([
            'message' => 'Clothing item updated successfully',
            'item' => $item
        ]);
    }

    // Delete a clothing item
    public function destroy(Request $request, $id)
    {
        $item = ClothingItem::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        // Delete image if exists
        if ($item->image_path) {
            Storage::disk('public')->delete($item->image_path);
        }

        $item->delete();

        return response()->json([
            'message' => 'Clothing item deleted successfully'
        ]);
    }

    // Get all available categories
    public function getCategories(Request $request)
    {
        $categories = ClothingItem::where('user_id', $request->user()->id)
            ->select('category')
            ->distinct()
            ->pluck('category');
            
        return response()->json($categories);
    }

    // Filter items by category
    public function filterByCategory(Request $request, $category)
    {
        $items = ClothingItem::where('user_id', $request->user()->id)
            ->where('category', $category)
            ->get();
            
        return response()->json($items);
    }

    // Search items
    public function search(Request $request, $query)
    {
        $items = ClothingItem::where('user_id', $request->user()->id)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('brand', 'like', "%{$query}%")
                  ->orWhere('color', 'like', "%{$query}%")
                  ->orWhere('notes', 'like', "%{$query}%");
            })
            ->get();
            
        return response()->json($items);
    }
}