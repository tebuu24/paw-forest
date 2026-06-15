<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>{{ __('Admin - Edit Animal') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v={{ time() }}">
    <link class="main-stylesheet" rel="stylesheet" href="{{ secure_asset('css/style.css') }}?v={{ time() }}">
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
            <div class="form-narrow-wrapper">
                <h1>{{ __('Modify Animal Details') }}</h1>
                <br>

                <div class="block-card block-card-padded">
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'employee')
                        <form action="/admin/animals/{{ $animal->id }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-flex-row-container">
                                <div class="flex-field-fill-proportionate">
                                    <label class="form-label-bold-block">{{ __('Name') }}</label>
                                    <input type="text" name="name" value="{{ old('name', $animal->name) }}" required class="form-control-field form-control-white-bg">
                                </div>
                                <div class="flex-field-fill-proportionate">
                                    <label class="form-label-bold-block">{{ __('Age') }}</label>
                                    <input type="number" name="age" value="{{ old('age', $animal->age) }}" min="0" class="form-control-field form-control-white-bg" placeholder="{{ __('e.g. 2') }}">
                                </div>
                            </div>

                            <div class="form-flex-row-container">
                                <div class="flex-field-fill-proportionate">
                                    <label class="form-label-bold-block">{{ __('Species') }}</label>
                                    <input type="text" name="species" value="{{ old('species', $animal->species) }}" required class="form-control-field form-control-white-bg">
                                </div>
                                <div class="flex-field-fill-proportionate">
                                    <label class="form-label-bold-block">{{ __('Breed') }}</label>
                                    <input type="text" name="breed" value="{{ old('breed', $animal->breed) }}" required class="form-control-field form-control-white-bg">
                                </div>
                            </div>

                            <div class="form-flex-row-container">
                                <div class="flex-field-fill-proportionate">
                                    <label class="form-label-bold-block">{{ __('Gender') }}</label>
                                    <select name="gender" class="form-control-field form-control-white-bg">
                                        <option value="Male" {{ old('gender', $animal->gender) === 'Male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                                        <option value="Female" {{ old('gender', $animal->gender) === 'Female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                                    </select>
                                </div>
                                <div class="flex-field-fill-proportionate">
                                    <label class="form-label-bold-block">{{ __('Health Status') }}</label>
                                    <input type="text" name="health_status" value="{{ old('health_status', $animal->health_status) }}" required class="form-control-field form-control-white-bg">
                                </div>
                            </div>

                            <div class="form-flex-row-container">
                                <div class="flex-field-fill-proportionate">
                                    <label class="form-label-bold-block">{{ __('Shelter Location') }}</label>
                                    <select name="location_id" required class="form-control-field form-control-white-bg">
                                        @foreach(\App\Models\Location::all() as $loc)
                                            <option value="{{ $loc->id }}" {{ old('location_id', $animal->location_id) == $loc->id ? 'selected' : '' }}>
                                                {{ $loc->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex-field-fill-proportionate">
                                    <label class="form-label-bold-block">{{ __('Date Added') }}</label>
                                    <input type="date" name="date_added" value="{{ old('date_added', $animal->date_added ? \Carbon\Carbon::parse($animal->date_added)->format('Y-m-d') : '') }}" required class="form-control-field form-control-white-bg">
                                </div>
                            </div>

                            <div class="form-group-spacing-large">
                                <label class="form-label-bold-block">{{ __('Animal Image') }}</label>
                                @if($animal->image)
                                    <div class="thumbnail-preview-wrapper">
                                        <img src="{{ asset($animal->image) }}" alt="Current Image" class="thumbnail-preview-img">
                                    </div>
                                @endif
                                <input type="file" name="image" accept="image/*" class="file-upload-input-spacing">
                            </div>

                            <div class="action-flex-gap-sm">
                                <button type="submit" class="btn btn-green">{{ __('Save Changes') }}</button>
                                <a href="/admin/animals" class="btn btn-cancel-secondary">{{ __('Cancel') }}</a>
                            </div>
                        </form>

                        <div class="danger-zone-divider">
                            <div class="danger-zone-card">
                                <h4 class="danger-zone-title">⚠️ {{ __('Danger Zone Management') }}</h4>
                                <p class="danger-zone-description">
                                    {{ __('Manage database status constraints for this system shelter animal record entry.') }}
                                </p>
                                
                                <div class="action-flex-wrap-gap-md">
                                    @if($animal->trashed())
                                        <form action="/admin/animals/{{ $animal->id }}/restore" method="POST" class="inline-form">
                                            @csrf
                                            <button type="submit" class="btn btn-blue danger-zone-btn">
                                                {{ __('Restore Entry') }}
                                            </button>
                                        </form>
                                    @else
                                        <form action="/admin/animals/{{ $animal->id }}" method="POST" onsubmit="return confirm('{{ __('Dzēst dzīvnieka ierakstu?') }}')" class="inline-form">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-red danger-zone-btn">
                                                {{ __('Archive') }}
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger custom-alert-denied">
                            {{ __('Access Denied. You do not have permission to edit records.') }}
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

</body>
</html>
