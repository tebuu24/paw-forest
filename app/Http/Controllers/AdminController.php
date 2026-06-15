<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Animal;
use App\Models\Adoption;
use App\Models\Donation;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::withTrashed()->orderBy('id', 'desc')->get();
        return view('pages.admin.admin-users', compact('users'));
    }

    public function block($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        if (auth()->user()->role === 'employee' && in_array($user->role, ['admin', 'employee'])) {
            abort(403, 'Unauthorized action.');
        }

        $user->is_blocked = !$user->is_blocked;
        $user->save();

        $statusMessage = $user->is_blocked ? __('User blocked successfully.') : __('User unblocked successfully.');
        
        return redirect()->back()->with('success', $statusMessage);
    }

    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_animals' => Animal::count(),
            'pending_adoptions' => Adoption::where('status', 'Pending')->count(),
            'total_donations' => Donation::sum('amount')
        ];

        return view('pages.dashboard', compact('stats'));
    }
}