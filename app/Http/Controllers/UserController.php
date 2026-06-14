<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        
        $user->load(['adoptionRequests.animal', 'shelterVisits.location', 'shelterVisits.animal']);

        return view('pages.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('user')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('user')->ignore($user->id)],
            'address' => ['required', 'string', 'max:500'],
        ]);

        $user->update($validated);

        return redirect()->back()->with('success', __('Profile updated successfully!'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', __('Password changed successfully!'));
    }
    public function destroy(Request $request)
    {
        $request->validate([
            'delete_password' => ['required', 'current_password'],
        ]);
        $user = Auth::user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', __('Your account has been deactivated.'));
    }

    public function dashboard()
    {
        $user = Auth::user();
        
        $donations = $user->donations()->orderBy('id', 'desc')->get();
        $applications = $user->adoptionRequests()->orderBy('id', 'desc')->get();

        return view('admin.dashboard', compact('user', 'donations', 'applications'));
    }
}