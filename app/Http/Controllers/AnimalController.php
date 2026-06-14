<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\Location;

class AnimalController extends Controller
{
    public function index(Request $request)
    {
        $query = Animal::with('location');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('species')) {
            $query->where('species', $request->species);
        }

        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        $allAnimals = $query->orderBy('id', 'desc')->get();
        
        $locations = Location::all();

        return view('pages.gallery', compact('allAnimals', 'locations'));
    }
    public function show($id)
    {
        $animal = Animal::with(['location', 'medicines'])->findOrFail($id);
        return view('pages.animal-profile', compact('animal'));
    }

    public function create() { return redirect()->back(); }
    public function store(Request $request) { return redirect()->back(); }
    public function edit($id) { return redirect()->back(); }
    public function update(Request $request, $id) { return redirect()->back(); }
    public function destroy($id) { return redirect()->back(); }

    public function home()
    {
        $recentAnimals = Animal::with('location')->orderBy('id', 'desc')->take(4)->get();
        return view('pages.index', compact('recentAnimals'));
    }
}