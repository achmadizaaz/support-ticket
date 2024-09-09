<div class="vertical-menu">    
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    <a href="{{ route('dashboard') }}">
                        <i class="bi bi-house-door"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>
               
                @canany(['create-tickets', 'read-tickets', 'read-all-tickets'])
                    <li class="menu-title" data-key="t-components">Ticket</li>
                @endcanany
                
                @can('create-tickets')
                <li>
                    <a href="{{ route('ticket.create') }}">
                        <i class="bi bi-ticket"></i>
                        <span data-key="t-ticket">Open Ticket</span>
                    </a>
                </li>
                @endcan

                @can('read-tickets')
                <li>
                    <a href="{{ route('ticket') }}">
                        <i class="bi bi-chat-text"></i>
                        <span data-key="t-ticket">My Support Tickets</span>
                    </a>
                </li>
                @endcan
                
                @can('read-all-tickets')
                <li>
                    <a href="{{ route('ticket.all') }}">
                        <i class="bi bi-headset"></i>
                        <span data-key="t-ticket">List Support Tickets</span>
                    </a>
                </li>
                @endcan
                
                
                @canany(['read-categories', 'read-units'])
                <li class="menu-title" data-key="t-referensi">Referensi</li>
                @endcanany
                @can('read-categories')
                <li>
                    <a href="{{ route('category') }}">
                        <i class="bi bi-tag"></i>
                        <span data-key="t-categories">Categories</span>
                    </a>
                </li>
                @endcan
                
                @can('read-units')
                    <li>
                    <a href="{{ route('unit') }}">
                        <i class="bi bi-bookmarks"></i>
                        <span data-key="t-unit">Units</span>
                    </a>
                </li>
                @endcan

                @can('read-notif-preferences')
                    <li>
                    <a href="{{ route('notif.categories') }}">
                        <i class="bi bi-app-indicator"></i>
                        <span data-key="t-notif-preferences">Notif by Category</span>
                    </a>
                </li>
                @endcan

                @can('read-users')
                <li class="menu-title" data-key="t-components">Management User</li>
                <li class="{{ request()->routeIs('users.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('users') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span data-key="t-users">Users</span>
                    </a>
                </li>
                @endcan

                @canany(['read-roles', 'read-permissions', 'read-sync-permission-roles'])
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="grid"></i>
                        <span data-key="t-rolepermission">Role Permission</span>
                    </a>
                    @canany(['read-roles', 'read-permissions', 'read-sync-permission-roles'])
                    <ul class="sub-menu" aria-expanded="false">
                        @can('read-roles')
                        <li>
                            <a href="{{ route('roles') }}">
                                <span data-key="t-role">Role</span>
                            </a>
                        </li>
                        @endcan
                        @can('read-permissions')
                        <li>
                            <a href="{{ route('permissions') }}">
                                <span data-key="t-role">Permission</span>
                            </a>
                        </li>
                        @endcan
                        @can('read-sync-permission-roles')
                        <li class="{{ request()->routeIs('sync.permissions.*') ? 'mm-active' : '' }}">
                            <a href="{{ route('sync.permissions') }}" class="{{ request()->routeIs('sync.permissions.*') ? 'active' : '' }}">
                                <span data-key="t-permission">Sync Permission Role</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                    @endcanany
                </li>
                @endcanany
                @can('read-options')
                    <li class="menu-title" data-key="t-components">Options</li>
                    <li>
                        <a href="{{ route('options') }}">
                            <i class="bi bi-gear"></i>
                            <span data-key="t-rolepermission">Settings</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</div>