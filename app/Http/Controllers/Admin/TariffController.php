<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tariff;
use Illuminate\Http\Request;

class TariffController extends Controller
{
    public function index()
    {
        $tariffs = Tariff::orderBy('sort_order')->get();
        return view('admin.tariffs.index', compact('tariffs'));
    }
    
    public function create()
    {
        return view('admin.tariffs.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:tariffs',
            'price' => 'required|integer',
            'period' => 'required|string',
            'features' => 'nullable',
            'is_popular' => 'nullable|boolean',
            'sort_order' => 'integer',
        ]);
        
        // Преобразуем features в массив
        $features = $request->features;
        if (is_string($features)) {
            $features = json_decode($features, true);
        }
        if (is_null($features)) {
            $features = [];
        }
        
        Tariff::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'price' => $request->price,
            'period' => $request->period,
            'features' => $features,
            'is_popular' => $request->has('is_popular') ? 1 : 0,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => 1,
        ]);
        
        return redirect()->route('admin.tariffs.index')->with('success', 'Тариф добавлен');
    }
    
    public function edit($id)
    {
        $tariff = Tariff::findOrFail($id);
        return view('admin.tariffs.edit', compact('tariff'));
    }
    
    public function update(Request $request, $id)
    {
        $tariff = Tariff::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:tariffs,slug,' . $id,
            'price' => 'required|integer',
            'period' => 'required|string',
            'features' => 'nullable',
            'is_popular' => 'nullable|boolean',
            'sort_order' => 'integer',
        ]);
        
        // Преобразуем features в массив
        $features = $request->features;
        if (is_string($features)) {
            $features = json_decode($features, true);
        }
        if (is_null($features)) {
            $features = [];
        }
        
        $tariff->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'price' => $request->price,
            'period' => $request->period,
            'features' => $features,
            'is_popular' => $request->has('is_popular') ? 1 : 0,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);
        
        return redirect()->route('admin.tariffs.index')->with('success', 'Тариф обновлен');
    }
    
    public function destroy($id)
    {
        $tariff = Tariff::findOrFail($id);
        $tariff->delete();
        
        return redirect()->route('admin.tariffs.index')->with('success', 'Тариф удален');
    }
}