<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withTrashed()->orderBy('date_joined', 'desc')->get();
        return view('pages.admin.admin-users', compact('users'));
    }

    public function show()
    {
        $user = Auth::user();
        $user->load(['adoptionRequests.animal', 'shelterVisits.location', 'shelterVisits.animal']);
        return view('pages.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'email'   => ['required', 'string', 'email', 'max:255'],
            'username'=> ['required', 'string', 'max:255'],
        ]);

        $emailExists = \App\Models\User::where('email', $request->email)
            ->where('id', '!=', $user->id)
            ->exists();
            
        if ($emailExists) {
            return redirect()->back()->withErrors(['email' => __('The email has already been taken.')])->withInput();
        }

        $usernameExists = \App\Models\User::where('username', $request->username)
            ->where('id', '!=', $user->id)
            ->exists();

        if ($usernameExists) {
            return redirect()->back()->withErrors(['username' => __('The username has already been taken.')])->withInput();
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->save();

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

    public function destroy(Request $request, $id = null)
    {
        if ($id) {
            $user = User::findOrFail($id);
            
            if (auth()->user()->role === 'employee' && in_array($user->role, ['admin', 'employee'])) {
                abort(403, 'Unauthorized action.');
            }

            $user->delete();
            return redirect()->back()->with('success', __('User account soft-deleted. Pending admin full deletion.'));
        }

        $request->validate(['delete_password' => ['required', 'current_password']]);
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

    public function adminUpdate(Request $request, $id)
    {
        $user = User::withTrashed()->findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update($validated);
        return redirect()->back()->with('success', __('User profile updated.'));
    }

    public function restore($id)
    {
        if (!in_array(auth()->user()->role, ['admin', 'employee'])) {
            abort(403, 'Unauthorized action.');
        }

        $user = User::withTrashed()->findOrFail($id);
        
        if (auth()->user()->role === 'employee' && in_array($user->role, ['admin', 'employee'])) {
            abort(403, 'Unauthorized action.');
        }

        $user->restore();

        return redirect()->back()->with('success', __('User account successfully reactivated.'));
    }

    public function forceDelete($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $user = User::withTrashed()->findOrFail($id);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $user->forceDelete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return redirect()->back()->with('success', __('User permanently wiped from database.'));
    }
}