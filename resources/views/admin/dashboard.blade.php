@extends('layouts.app')

@section('content')
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="list-group">
                <a href="{{ route('admin.posts.index') }}"
                    class="list-group-item list-group-item-action {{ request()->routeIs('admin.posts.index') || request()->routeIs('admin.posts.create') || request()->routeIs('admin.posts.edit') ? 'active' : '' }}">Posts</a>
                <a href="{{ route('admin.categories.index') }}"
                    class="list-group-item list-group-item-action {{ request()->routeIs('admin.categories.index') || request()->routeIs('admin.categories.edit') ? 'active' : '' }}">Categories</a>
                <a href="{{ route('admin.users.index') }}"
                    class="list-group-item list-group-item-action {{ request()->is('admin/users') ? 'active' : '' }}">Users</a>
                <a href="{{ route('admin.settings.index') }}"
                    class="list-group-item list-group-item-action {{ request()->is('admin/settings') ? 'active' : '' }}">Settings</a>
            </div>
        </div>

        <!-- Content Area -->
        <div class="col-md-9">
            @yield('dashboard-content')
        </div>
    </div>
@endsection
