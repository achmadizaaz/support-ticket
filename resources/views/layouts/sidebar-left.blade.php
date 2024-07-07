<div class="vertical-menu">    
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Menu</li>

                <li>
                    <a href="{{ route('dashboard') }}">
                        <i class="bi bi-house-door"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>
                <li class="menu-title" data-key="t-components">Management User</li>
                <li class="{{ request()->routeIs('users.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('users') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span data-key="t-users">Users</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="grid"></i>
                        <span data-key="t-rolepermission">Role Permission</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('roles') }}">
                                <span data-key="t-role">Role</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('permissions') }}">
                                <span data-key="t-role">Permission</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('sync.permissions.*') ? 'mm-active' : '' }}">
                            <a href="{{ route('sync.permissions') }}" class="{{ request()->routeIs('sync.permissions.*') ? 'active' : '' }}">
                                <span data-key="t-permission">Sync Permission Role</span>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Option Menu --}}
                <li class="menu-title" data-key="t-components">Options</li>
                <li>
                    <a href="{{ route('options') }}">
                        <i class="bi bi-gear"></i>
                        <span data-key="t-rolepermission">Settings</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>