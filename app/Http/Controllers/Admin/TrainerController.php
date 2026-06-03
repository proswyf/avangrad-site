<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    public function index()
    {
        $trainers = Trainer::orderBy('sort_order')->get();
        return view('admin.trainers.index', compact('trainers'));
    }
    
    public function create()
    {
        return view('admin.trainers.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:trainers',
            'position' => 'required|string',
            'experience' => 'required|integer',
            'specialization' => 'required|string',
            'certificates' => 'nullable|string',
            'quote' => 'nullable|string',
            'image' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'sort_order' => 'integer',
        ]);
        
        Trainer::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'position' => $request->position,
            'experience' => $request->experience,
            'specialization' => $request->specialization,
            'certificates' => $request->certificates,
            'quote' => $request->quote,
            'image' => $request->image,
            'price' => $request->filled('price') ? $request->price : null,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => 1,
        ]);
        
        return redirect()->route('admin.trainers.index')->with('success', 'Тренер добавлен');
    }
    
    public function edit($id)
    {
        $trainer = Trainer::findOrFail($id);
        return view('admin.trainers.edit', compact('trainer'));
    }
    
    public function update(Request $request, $id)
    {
        $trainer = Trainer::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:trainers,slug,' . $id,
            'position' => 'required|string',
            'experience' => 'required|integer',
            'specialization' => 'required|string',
            'certificates' => 'nullable|string',
            'quote' => 'nullable|string',
            'image' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'sort_order' => 'integer',
        ]);
        
        $trainer->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'position' => $request->position,
            'experience' => $request->experience,
            'specialization' => $request->specialization,
            'certificates' => $request->certificates,
            'quote' => $request->quote,
            'image' => $request->image,
            'price' => $request->filled('price') ? $request->price : null,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);
        
        return redirect()->route('admin.trainers.index')->with('success', 'Тренер обновлен');
    }
    
    public function destroy($id)
    {
        $trainer = Trainer::findOrFail($id);
        $trainer->delete();
        
        return redirect()->route('admin.trainers.index')->with('success', 'Тренер удален');
    }
}
