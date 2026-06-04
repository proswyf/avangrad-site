<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\HandlesImageUploads;
use App\Models\GroupClass;
use Illuminate\Http\Request;

class GroupClassController extends Controller
{
    use HandlesImageUploads;

    public function index()
    {
        $classes = GroupClass::orderBy('name')->get();
        return view('admin.classes.index', compact('classes'));
    }
    
    public function create()
    {
        return view('admin.classes.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:group_classes',
            'description' => 'required|string',
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
            'instructor' => 'required|string',
            'duration' => 'required|integer',
            'max_people' => 'required|integer',
            'schedule' => 'required|string',
            'days' => 'nullable',
        ]);

        $image = $this->storeImageUpload($request->file('image_file'), 'classes');
        
        // Преобразуем дни в массив
        $days = $request->days;
        if (is_string($days)) {
            $days = json_decode($days, true);
        }
        if (is_null($days)) {
            $days = [];
        }
        
        GroupClass::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'image' => $image,
            'instructor' => $request->instructor,
            'duration' => $request->duration,
            'max_people' => $request->max_people,
            'schedule' => $request->schedule,
            'days' => $days,
            'is_active' => 1,
        ]);
        
        return redirect()->route('admin.classes.index')->with('success', 'Занятие добавлено');
    }
    
    public function edit($id)
    {
        $class = GroupClass::findOrFail($id);
        return view('admin.classes.edit', compact('class'));
    }
    
    public function update(Request $request, $id)
    {
        $class = GroupClass::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:group_classes,slug,' . $id,
            'description' => 'required|string',
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
            'instructor' => 'required|string',
            'duration' => 'required|integer',
            'max_people' => 'required|integer',
            'schedule' => 'required|string',
            'days' => 'nullable',
        ]);

        $image = $this->storeImageUpload($request->file('image_file'), 'classes') ?? $class->image;
        
        // Преобразуем дни в массив
        $days = $request->days;
        if (is_string($days)) {
            $days = json_decode($days, true);
        }
        if (is_null($days)) {
            $days = [];
        }
        
        $class->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'image' => $image,
            'instructor' => $request->instructor,
            'duration' => $request->duration,
            'max_people' => $request->max_people,
            'schedule' => $request->schedule,
            'days' => $days,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);
        
        return redirect()->route('admin.classes.index')->with('success', 'Занятие обновлено');
    }
    
    public function destroy($id)
    {
        $class = GroupClass::findOrFail($id);
        $class->delete();
        
        return redirect()->route('admin.classes.index')->with('success', 'Занятие удалено');
    }
}
