<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Admin - Edit Animal') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
</head>
<body>

    <div class="admin-layout">
        <aside class="admin-sidebar">
            <div class="admin-sidebar-nav">
                <h2 class="admin-sidebar-title">🏠 Paw Forest</h2>
                <ul class="admin-menu">
                    <li><a href="/dashboard">{{ __('Dashboard') }}</a></li>
                    <li class="active"><a href="/admin/animals">{{ __('Animals') }}</a></li>
                    <li><a href="/admin/applications">{{ __('Applications') }}</a></li>
                    @if(auth()->user()->role === 'admin')
                        <li><a href="/admin/donations">{{ __('Donations') }}</a></li>
                    @endif
                    <li><a href="/admin/medicine">{{ __('Medications') }}</a></li>
                    <li><a href="/admin/locations">{{ __('Locations') }}</a></li>
                    <li><a href="/admin/users">{{ __('Users') }}</a></li>
                </ul>
            </div>
            <div>
                <a href="/admin/animals" class="btn btn-blue logout-btn margin-bottom-sm">⬅️ {{ __('Back to List') }}</a>
            </div>
        </aside>

        <main class="admin-main">
            <div style="max-width: 600px; margin: 0 auto;">
                <h1>{{ __('Modify Animal Details') }}</h1>
                <br>

                <div class="block-card" style="padding: 25px;">
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'employee')
                        <form action="/admin/animals/{{ $animal->id }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div style="margin-bottom: 15px;">
                                <label style="font-weight: bold; display: block; margin-bottom: 5px;">{{ __('Name') }}</label>
                                <input type="text" name="name" value="{{ old('name', $animal->name) }}" required style="width:100%; padding:8px; border: 1px solid #bbaaa2; border-radius:4px; background: #fff;">
                            </div>

                            <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                                <div style="flex: 1;">
                                    <label style="font-weight: bold; display: block; margin-bottom: 5px;">{{ __('Species') }}</label>
                                    <input type="text" name="species" value="{{ old('species', $animal->species) }}" required style="width:100%; padding:8px; border: 1px solid #bbaaa2; border-radius:4px; background: #fff;">
                                </div>
                                <div style="flex: 1;">
                                    <label style="font-weight: bold; display: block; margin-bottom: 5px;">{{ __('Breed') }}</label>
                                    <input type="text" name="breed" value="{{ old('breed', $animal->breed) }}" required style="width:100%; padding:8px; border: 1px solid #bbaaa2; border-radius:4px; background: #fff;">
                                </div>
                            </div>

                            <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                                <div style="flex: 1;">
                                    <label style="font-weight: bold; display: block; margin-bottom: 5px;">{{ __('Gender') }}</label>
                                    <select name="gender" style="width:100%; padding:8px; border: 1px solid #bbaaa2; border-radius:4px; background: #fff;">
                                        <option value="Male" {{ old('gender', $animal->gender) === 'Male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                                        <option value="Female" {{ old('gender', $animal->gender) === 'Female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                                    </select>
                                </div>
                                <div style="flex: 1;">
                                    <label style="font-weight: bold; display: block; margin-bottom: 5px;">{{ __('Health Status') }}</label>
                                    <input type="text" name="health_status" value="{{ old('health_status', $animal->health_status) }}" required style="width:100%; padding:8px; border: 1px solid #bbaaa2; border-radius:4px; background: #fff;">
                                </div>
                            </div>

                            <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                                <div style="flex: 1;">
                                    <label style="font-weight: bold; display: block; margin-bottom: 5px;">{{ __('Shelter Location') }}</label>
                                    <select name="location_id" required style="width:100%; padding:8px; border: 1px solid #bbaaa2; border-radius:4px; background: #fff;">
                                        @foreach(\App\Models\Location::all() as $loc)
                                            <option value="{{ $loc->id }}" {{ old('location_id', $animal->location_id) == $loc->id ? 'selected' : '' }}>
                                                {{ $loc->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="flex: 1;">
                                    <label style="font-weight: bold; display: block; margin-bottom: 5px;">{{ __('Date Added') }}</label>
                                    <input type="date" name="date_added" value="{{ old('date_added', $animal->date_added ? \Carbon\Carbon::parse($animal->date_added)->format('Y-m-d') : '') }}" required style="width:100%; padding:8px; border: 1px solid #bbaaa2; border-radius:4px; background: #fff;">
                                </div>
                            </div>

                            <div style="margin-bottom: 25px;">
                                <label style="font-weight: bold; display: block; margin-bottom: 5px;">{{ __('Animal Image') }}</label>
                                @if($animal->image)
                                    <div style="margin-bottom: 10px;">
                                        <img src="{{ asset($animal->image) }}" alt="Current Image" style="max-width: 150px; border-radius: 6px; border: 1px solid #bbaaa2;">
                                    </div>
                                @endif
                                <input type="file" name="image" accept="image/*" style="padding: 5px 0;">
                            </div>

                            <div style="display: flex; gap: 10px;">
                                <button type="submit" class="btn btn-green">{{ __('Save Changes') }}</button>
                                <a href="/admin/animals" class="btn" style="background:#e2dcd8; color:#333; padding: 10px 16px; text-decoration:none; border-radius:4px; font-size: 0.9rem;">{{ __('Cancel') }}</a>
                            </div>
                        </form>

                        <div style="margin-top: 35px; padding-top: 25px; border-top: 1px solid #fee2e2;">
                            <div style="background-color: #fef2f2; border: 1px solid #fca5a5; padding: 20px; border-radius: 8px;">
                                <h4 style="color: #991b1b; margin: 0 0 8px 0; font-size: 1.05rem; font-weight: bold;">⚠️ {{ __('Danger Zone Management') }}</h4>
                                <p style="color: #7f1d1d; font-size: 0.85rem; margin: 0 0 15px 0; line-height: 1.4;">
                                    {{ __('Manage database status constraints for this system shelter animal record entry.') }}
                                </p>
                                
                                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                                    @if($animal->trashed())
                                        <form action="/admin/animals/{{ $animal->id }}/restore" method="POST" style="margin:0;">
                                            @csrf
                                            <button type="submit" class="btn btn-blue" style="padding: 10px 16px; font-size: 0.85rem;">
                                                {{ __('Restore Entry') }}
                                            </button>
                                        </form>
                                    @else
                                        <form action="/admin/animals/{{ $animal->id }}" method="POST" onsubmit="return confirm('{{ __('Dzēst dzīvnieka ierakstu?') }}')" style="margin:0;">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-red" style="padding: 10px 16px; font-size: 0.85rem; font-weight: 500;">
                                                {{ __('Archive') }}
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px;">
                            {{ __('Access Denied. You do not have permission to edit records.') }}
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

</body>
</html>