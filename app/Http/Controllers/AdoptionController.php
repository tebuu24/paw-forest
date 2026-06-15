<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Adoption;
use App\Models\Animal;

class AdoptionController extends Controller
{
    public function approve($id)
    {
        $adoption = Adoption::findOrFail($id);
        $adoption->update(['status' => 'Approved']);

        return redirect()->back()->with('status', __('Application has been approved.'));
    }

    public function reject($id)
    {
        $adoption = Adoption::findOrFail($id);
        $adoption->update(['status' => 'Rejected']);

        return redirect()->back()->with('status', __('Application has been rejected.'));
    }

    public function destroy($id)
    {
        $adoption = Adoption::findOrFail($id);
        $adoption->delete();

        return redirect()->back()->with('status', __('Application deleted successfully.'));
    }

    public function restore($id)
    {
        $adoption = Adoption::withTrashed()->findOrFail($id);
        $adoption->restore();

        return redirect()->back()->with('status', __('Application restored to active view.'));
    }

    public function forceDelete($id)
    {
        $adoption = Adoption::withTrashed()->findOrFail($id);
        $adoption->forceDelete();

        return redirect()->back()->with('status', __('Application record completely erased.'));
    }
      public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', __('Please log in to apply for adoption.'));
        }
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'comment' => 'required|string|min:10|max:1500',
        ]);
        $adoption = new Adoption();
        $adoption->date = now()->toDateString();
        $adoption->status = 'Pending';
        $adoption->comment = $request->comment;
        $adoption->user_id = auth()->id();
        $adoption->animal_id = $request->animal_id;
        $adoption->save();

        return redirect()->back()->with('success', __('Your adoption application has been submitted successfully! We will review it shortly.'));
    }
}