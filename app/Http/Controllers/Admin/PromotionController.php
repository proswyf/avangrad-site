<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::orderBy('sort_order')->get();
        return view('admin.promotions.index', compact('promotions'));
    }
    
    public function create()
    {
        return view('admin.promotions.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:promotions',
            'description' => 'required|string',
            'badge' => 'nullable|string',
            'image' => 'nullable|string',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date',
            'sort_order' => 'integer',
        ]);
        
        Promotion::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'description' => $request->description,
            'details' => $request->details,
            'badge' => $request->badge,
            'image' => $request->image,
            'valid_from' => $request->valid_from,
            'valid_to' => $request->valid_to,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => 1,
        ]);
        
        return redirect()->route('admin.promotions.index')->with('success', 'Акция добавлена');
    }
    
    public function edit($id)
    {
        $promotion = Promotion::findOrFail($id);
        return view('admin.promotions.edit', compact('promotion'));
    }
    
    public function update(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:promotions,slug,' . $id,
            'description' => 'required|string',
            'badge' => 'nullable|string',
            'image' => 'nullable|string',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date',
            'sort_order' => 'integer',
        ]);
        
        $promotion->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'description' => $request->description,
            'details' => $request->details,
            'badge' => $request->badge,
            'image' => $request->image,
            'valid_from' => $request->valid_from,
            'valid_to' => $request->valid_to,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);
        
        return redirect()->route('admin.promotions.index')->with('success', 'Акция обновлена');
    }
    
    public function destroy($id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->delete();
        
        return redirect()->route('admin.promotions.index')->with('success', 'Акция удалена');
    }
}