<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;

class DonationController extends Controller
{
    public function index()
    {
        if (!auth()->check() || !auth()->user()->isEmployee()) {
            abort(403, 'Unauthorized action.');
        }

        $donations = Donation::with('user')->orderBy('id', 'desc')->get();
        return view('pages.admin.admin-donations', compact('donations'));
    }

    public function create()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', __('Please log in to make a donation.'));
        }

        $currentSum = Donation::sum('amount');
        $targetGoal = 5000;
        $progressPercentage = $targetGoal > 0 ? min(($currentSum / $targetGoal) * 100, 100) : 0;

        return view('pages.donations', compact('currentSum', 'targetGoal', 'progressPercentage'));
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'amount' => 'required|numeric|min:1',
            'method_of_payment' => 'required|string|in:Card,PayPal,Bank Transfer',
            'message' => 'nullable|string|max:1000',
        ]);

        $donation = new Donation();
        $donation->amount = $request->amount;
        $donation->method_of_payment = $request->method_of_payment;
        $donation->message = $request->message;
        $donation->date = now()->toDateString();
        $donation->user_id = auth()->id();
        $donation->save();

        return redirect()->route('donations.create')
            ->with('success', __('Thank you for your donation!'));
    }

    public function show($id)
    {
        if (!auth()->check() || !auth()->user()->isEmployee()) {
            abort(403, 'Unauthorized action.');
        }

        $donation = Donation::with('user')->findOrFail($id);
        return view('pages.admin.admin-donation-show', compact('donation'));
    }
    public function edit($id)
    {
        $donation = Donation::withTrashed()->with('user')->findOrFail($id);
        return view('pages.admin.donations-edit', compact('donation'));
    }

    public function update(Request $request, $id)
    {
        $donation = Donation::withTrashed()->findOrFail($id);
        
        $data = $request->validate([
            'method_of_payment' => 'required|string',
            'message'           => 'nullable|string'
        ]);
        
        $donation->update($data);
        return redirect('/admin/donations')->with('status', __('Donation record saved.'));
    }

    public function destroy($id)
    {
        // soft delete the record automatically if the trait is on the model
        $donation = Donation::findOrFail($id);
        $donation->delete(); 
        
        return redirect('/admin/donations')->with('status', __('Donation record archived.'));
    }

    public function restore($id)
    {
        // Add the restore mechanism for the admin dashboard button
        $donation = Donation::withTrashed()->findOrFail($id);
        $donation->restore();

        return redirect('/admin/donations')->with('status', __('Donation record restored successfully.'));
    }
}