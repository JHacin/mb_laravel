<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('dashboard') }}">
        <i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}
    </a>
    <a class="nav-link" href="{{ backpack_url('user') }}">
        <i class="la la-user nav-icon"></i> {{ trans('backpack::permissionmanager.users') }}
    </a>
    <a class="nav-link" href="{{ backpack_url('role') }}">
        <i class="la la-id-badge nav-icon"></i> {{ trans('backpack::permissionmanager.roles') }}
    </a>
    <a class="nav-link" href="{{ backpack_url('permission') }}">
        <i class="la la-key nav-icon"></i> {{ trans('backpack::permissionmanager.permission_plural') }}
    </a>
</li>
