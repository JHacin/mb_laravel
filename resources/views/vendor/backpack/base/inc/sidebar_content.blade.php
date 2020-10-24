<li class='nav-item'>
    <a class="nav-link" href="{{ backpack_url(config('routes.admin.dashboard')) }}">
        <i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}
    </a>
</li>

<li class='nav-item'>
    <div class="nav-title">Muce</div>
    <a class='nav-link' href='{{ backpack_url(config('routes.admin.cats')) }}'>
        <i class='nav-icon la la-cat'></i> Muce
    </a>
    <a class='nav-link' href='{{ backpack_url(config('routes.admin.cat_locations')) }}'>
        <i class='nav-icon la la-map-marker'></i> Lokacije
    </a>
</li>

<li class='nav-item'>
    <div class="nav-title">Botrovanja</div>
    <a class='nav-link' href='{{ backpack_url(config('routes.admin.sponsorships')) }}'>
        <i class='nav-icon la la-hands-helping'></i> Botrovanja
    </a>
</li>

<li class="nav-item">
    <div class="nav-title">Uporabniki</div>
    <a class="nav-link" href="{{ backpack_url(config('routes.admin.users')) }}">
        <i class="la la-user nav-icon"></i> {{ trans('backpack::permissionmanager.users') }}
    </a>
    <a class="nav-link" href="{{ backpack_url(config('routes.admin.roles')) }}">
        <i class="la la-id-badge nav-icon"></i> {{ trans('backpack::permissionmanager.roles') }}
    </a>
    <a class="nav-link" href="{{ backpack_url(config('routes.admin.permissions')) }}">
        <i class="la la-key nav-icon"></i> {{ trans('backpack::permissionmanager.permission_plural') }}
    </a>
</li>

