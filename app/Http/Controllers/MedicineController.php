<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Animal;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index()
    {
        $medicines = Medicine::withTrashed()->with(['animal', 'employee'])->get();
        $animals = Animal::all();
        return view('pages.admin.admin-medicine', compact('medicines', 'animals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'animal_id'     => 'required|exists:animals,id',
            'name'          => 'required|string|max:255',
            'description'   => 'required|string',
            'method_of_use' => 'required|string|max:255',
            'frequency'     => 'required|string|max:255',
            'date_from'     => 'required|date',
            'date_until'    => 'required|date|after_or_equal:date_from',
        ]);

        $employee = \App\Models\Employee::where('user_id', auth()->id())->first();

        if (!$employee) {
            if (auth()->user()->role === 'admin') {
                $fallbackLocation = \Illuminate\Support\Facades\DB::table('locations')->value('id');
                $locationId = $fallbackLocation ?? 1;

                $employee = \App\Models\Employee::firstOrCreate(
                    ['user_id' => auth()->id()],
                    [
                        'name'        => auth()->user()->name ?? 'System Admin',
                        'location_id' => $locationId
                    ]
                );
            } else {
                return redirect()->back()->with('error', __('You do not have a valid employee profile to log medications.'));
            }
        }

        $validated['employee_id'] = $employee->id;
        
        Medicine::create($validated);

        return redirect('/admin/medicine')->with('status', __('Medication added successfully!'));
    }

    public function edit($id)
    {
        $med = Medicine::withTrashed()->findOrFail($id);
        return view('pages.admin.medicine-edit', compact('med'));
    }

    public function update(Request $request, $id)
    {
        $med = Medicine::withTrashed()->findOrFail($id);
        
        $validated = $request->validate([
            'animal_id'     => 'required',
            'name'          => 'required|string',
            'description'   => 'required|string',
            'method_of_use' => 'required|string',
            'frequency'     => 'required|string',
            'date_from'     => 'required|date',
            'date_until'    => 'required|date',
        ]);

        $med->update($validated);
        return redirect('/admin/medicine')->with('status', __('Medication details updated successfully!'));
    }

    public function destroy($id)
    {
        Medicine::findOrFail($id)->delete();
        
        return redirect('/admin/medicine')->with('status', __('Record archived successfully!'));
    }

    public function restore($id)
    {
        Medicine::withTrashed()->findOrFail($id)->restore();
        return redirect()->back()->with('status', __('Medication log successfully restored!'));
    }

    public function forceDelete($id)
    {
        Medicine::withTrashed()->findOrFail($id)->forceDelete();
        return redirect('/admin/medicine')->with('status', __('Medication log permanently purged from system.'));
    }
}