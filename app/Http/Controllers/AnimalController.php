<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;

class AnimalController extends Controller
{
    public function index()
    {
        $allAnimals = Animal::with('location')->orderBy('id', 'desc')->get();
        return view('pages.gallery', compact('allAnimals'));
    }
    public function show($id)
    {
        $animal = Animal::with(['location', 'medicines'])->findOrFail($id);
        return view('pages.animal-profile', compact('animal'));
    }
    public function search(Request $request)
    {
        $query = Animal::query();

        if ($request->has('species') && $request->species != '') {
            $query->where('species', $request->species);
        }

        if ($request->has('name') && $request->name != '') {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $allAnimals = $query->orderBy('id', 'desc')->get();
        return view('pages.gallery', compact('allAnimals'));
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