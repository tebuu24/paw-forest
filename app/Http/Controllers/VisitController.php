<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visit;
use App\Models\Animal;
use App\Models\Employee;

class VisitController extends Controller
{
    public function index() {}
    public function create() {}
    public function show($id) {}
    public function updateStatus(Request $request, $id) {}

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', __('Please log in to apply for a visit.'));
        }
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'visit_date' => 'required|date|after:today',
            'visit_time' => 'required',
            'comment' => 'nullable|string|max:1000',
        ]);

        $animal = Animal::findOrFail($request->animal_id);

        $combinedDateTime = $request->visit_date . ' ' . $request->visit_time;

        $visit = new Visit();
        $visit->date = $combinedDateTime;
        $visit->comment = $request->comment;
        $visit->status = 'Pending';
        $visit->user_id = auth()->id();
        $visit->animal_id = $animal->id;
        $visit->location_id = $animal->location_id;
        $visit->employee_id = null;
        $visit->save();

        return redirect()->back()->with('success', __('Your visitation request has been submitted successfully!'));
    }
    public function approve($id)
    {
        $visit = Visit::findOrFail($id);
        
        $employee = Employee::where('user_id', auth()->id())->first();

        $visit->update([
            'status'      => 'Approved',
            'employee_id' => $employee ? $employee->id : null
        ]); 

        return redirect()->back()->with('status', __('Visit has been approved.'));
    }

    public function reject($id)
    {
        $visit = Visit::findOrFail($id);
        
        $employee = Employee::where('user_id', auth()->id())->first();

        $visit->update([
            'status'      => 'Rejected',
            'employee_id' => $employee ? $employee->id : null
        ]);

        return redirect()->back()->with('status', __('Visit has been rejected.'));
    }

    //Soft delete / Archive a visit record.

    public function destroy($id)
    {
        $visit = Visit::findOrFail($id);
        $visit->delete();

        return redirect()->back()->with('status', __('Visit record deleted successfully.'));
    }

    //Restore an archived visit record.
    public function restore($id)
    {
        $visit = Visit::withTrashed()->findOrFail($id);
        $visit->restore();

        return redirect()->back()->with('status', __('Visit restored to active view.'));
    }

    //Permanently delete a visit record (Admin Only).
    public function forceDelete($id)
    {
        $visit = Visit::withTrashed()->findOrFail($id);
        $visit->forceDelete();

        return redirect()->back()->with('status', __('Visit record completely erased.'));
    }
}