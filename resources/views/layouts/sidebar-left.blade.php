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
                <li class="menu-title mt-2" data-key="t-components">Management User</li>
                <li>
                    <a href="{{ route('users') }}">
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
                            <a href="{{ route('sync.permissions') }}">
                                <span data-key="t-permission">Sync Permission</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>