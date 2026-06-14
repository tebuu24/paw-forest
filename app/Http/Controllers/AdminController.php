<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Adoption;
use App\Models\Visit;
use App\Models\Donation;
use App\Models\Medicine;
use App\Models\Location;

class AdminController extends Controller
{
    public function index()
    {
        $currentUser = auth()->user();
        if ($currentUser->isAdmin()) {
            $users = \App\Models\User::withTrashed()->orderBy('date_joined', 'desc')->get();
        } else {
            $users = \App\Models\User::orderBy('date_joined', 'desc')->get();
        }
        return view('pages.admin.admin-users', ['users' => $users]);
    }

    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'pending_adoptions' => Adoption::where('status', 'pending')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
    public function block($id)
    {
        return redirect()->back();
    }
}