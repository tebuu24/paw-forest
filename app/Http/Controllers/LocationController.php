<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    public function update(Request $request, $id)
    {
        $location = Location::withTrashed()->findOrFail($id);
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255'
        ]);

        $location->update($data);

        return redirect('/admin/locations')->with('status', __('Location data modified successfully!'));
    }

    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete(); 

        return redirect('/admin/locations')->with('status', __('Location removed from system.'));
    }
}