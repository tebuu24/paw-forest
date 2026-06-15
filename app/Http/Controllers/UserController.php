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
    // Pašreizējā autorizētā lietotāja personīgais profils (front-end)
    public function show()
    {
        $user = Auth::user();
        $user->load(['adoptionRequests.animal', 'shelterVisits.location', 'shelterVisits.animal']);
        return view('pages.profile', compact('user'));
    }

    // Paša lietotāja profila datu labošana
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
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

  public function destroy(Request $request, $id = null)
    {
        if ($id) {
            // Darbinieks/Admins deaktivizē lietotāju
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->back()->with('success', __('User account soft-deleted. Pending admin full deletion.'));
        }

        // Lietotājs pats dzēš savu kontu
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

    // Admin panelim: Darbinieka/Admina iespēja labot citus lietotājus
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

    // Atjaunot lietotāju (Tikai Adminam)
    public function restore($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->back()->with('success', __('User account successfully reactivated.'));
    }

    // Pilnīga izdzēšana no DB (Tikai Adminam)
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