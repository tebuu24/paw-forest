<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\Location;
use App\Models\Medicine;
use Illuminate\Support\Facades\Storage;

class AnimalController extends Controller
{
    private function queryAvailableAnimals()
    {
        return Animal::whereNotIn('id', function ($query) {
            $query->select('animal_id')
                  ->from('adoptions')
                  ->where('status', 'Approved');
        });
    }

    public function index(Request $request)
    {
        $locations = Location::all();
        $query = $this->queryAvailableAnimals()->with('location');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->filled('species')) {
            $query->where('species', $request->input('species'));
        }

        if ($request->filled('location_id')) {
            $query->where('location_id', $request->input('location_id'));
        }

        $allAnimals = $query->orderBy('id', 'desc')->get();

        return view('pages.gallery', compact('allAnimals', 'locations'));
    }

    public function adminIndex()
    {
        $allAnimals = Animal::withTrashed()->with('location')->orderBy('id', 'desc')->get();
        return view('pages.admin.admin-animals', compact('allAnimals'));
    }

    public function create() 
    { 
        $locations = Location::all();
        return view('pages.admin.animals-create', compact('locations')); 
    }

    public function store(Request $request) 
    { 
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'species'       => 'required|string|max:255',
            'breed'         => 'nullable|string|max:255',
            'gender'        => 'required|in:Male,Female',
            'health_status' => 'required|string|max:255',
            'location_id'   => 'required|exists:locations,id',
            'date_added'    => 'required|date|after_or_equal:1970-01-01|before_or_equal:tomorrow',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'age'           => 'nullable|integer|min:0',
        ], [
            'date_added.after_or_equal' => __('Please enter a realistic, modern date entry.'),
            'date_added.before_or_equal' => __('The date added cannot be in the far future.'),
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('animals', 'public');
            $validated['image'] = 'storage/' . $imagePath;
        }

        Animal::create($validated);

        return redirect()->back()->with('status', __('Animal added successfully!'));
    }

    public function edit($id)
    {
        $animal = Animal::withTrashed()->findOrFail($id);
        $locations = Location::all();
        return view('pages.admin.animals-edit', compact('animal', 'locations'));
    }

    public function update(Request $request, $id)
    {
        $animal = Animal::withTrashed()->findOrFail($id);
        
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'species'       => 'required|string|max:255',
            'breed'         => 'nullable|string|max:255',
            'gender'        => 'required|in:Male,Female',
            'health_status' => 'required|string|max:255',
            'location_id'   => 'required|exists:locations,id',
            'date_added'    => 'required|date|after_or_equal:1970-01-01|before_or_equal:tomorrow',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'age'           => 'nullable|integer|min:0',
        ], [
            'date_added.after_or_equal' => __('Please enter a realistic, modern date entry.'),
            'date_added.before_or_equal' => __('The date added cannot be in the far future.'),
        ]);

        if ($request->hasFile('image')) {
            if ($animal->image) {
                $oldPath = str_replace('storage/', '', $animal->image);
                Storage::disk('public')->delete($oldPath);
            }

            $imagePath = $request->file('image')->store('animals', 'public');
            $validated['image'] = 'storage/' . $imagePath;
        }

        $animal->update($validated);

        return redirect('/admin/animals')->with('status', __('Animal profile updated successfully!'));
    }

    public function destroy($id)
    {
        $animal = Animal::findOrFail($id);
        $animal->delete(); 

        return redirect('/admin/animals')->with('status', __('Animal record archived safely.'));
    }

    public function restore($id)
    {
        $animal = Animal::withTrashed()->findOrFail($id);
        $animal->restore();

        return redirect('/admin/animals')->with('status', __('Animal record brought back to active tables.'));
    }

    public function forceDelete($id)
    {
        $animal = Animal::withTrashed()->findOrFail($id);

        if ($animal->image) {
            $relativeStoragePath = str_replace('storage/', '', $animal->image);
            
            if (Storage::disk('public')->exists($relativeStoragePath)) {
                Storage::disk('public')->delete($relativeStoragePath);
            }
        }

        $animal->forceDelete();

        return redirect('/admin/animals')->with('status', __('Animal and its images completely purged permanently.'));
    }

    public function home()
    {
        $recentAnimals = $this->queryAvailableAnimals()
            ->with('location')
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();

        return view('pages.index', compact('recentAnimals'));
    }
    public function show($id)
    {
        $animal = Animal::with(['location', 'medicines'])->findOrFail($id);
        return view('pages.animal-profile', compact('animal'));
    }
}