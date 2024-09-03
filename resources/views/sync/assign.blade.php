@extends('layouts.main')

@section('title', 'Assign Permission')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="card p-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Sync Permission: {{ $currentRole->name }}</h4>
                <div class="page-title-right">
                    <div class="page-title-right">
                        <button type="submit" class="btn btn-primary" form="assignForm">
                            <i class="bi bi-arrow-repeat me-1"></i> Synchronize
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Alert  -->
        {{-- Alert Success --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i> {!! session('success') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        {{-- Alert Failed --}}
        @if (session('failed'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i> {{ session('failed') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <h5 class="alert-heading">
                    <i class="bi bi-exclamation-circle me-2"></i>  Errors:
                </h5>
                {{-- Button close --}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <hr>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- end Alert -->

        <!-- start page main -->
        
         {{-- Change Role --}}
         @include('sync.select-role')
         {{-- END Change Role --}}
        <form action="{{ route('sync.permissions.store') }}" method="POST" id="assignForm">
            <input type="hidden" name="role" value="{{ $currentRole->id }}">
            @csrf
            <div class="card p-3">
                <table class="table table-striped">
                    <thead>
                        <th>Modul</th>
                        <th>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                                <label class="form-check-label" for="selectAll">
                                    Check All
                                </label>
                            </div>
                        </th>
                        <th>Create</th>
                        <th>Read</th>
                        <th>Update</th>
                        <th>Delete</th>
                        <th>Other</th>
                    </thead>
                    <tbody>
                        {{-- Modul Ticket --}}
                        <tr>
                            <td class="fw-bold">Support Ticket</td>
                            <td>
                                <input class="form-check-input me-2 checkbox checkAllTicket" type="checkbox" id="all-ticket" onclick="checkAllTicket(this)">
                                <label class="form-check-label" for="all-ticket">
                                    All Ticket
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'create-tickets')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox ticket-group" type="checkbox" id="createUser" value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('create-tickets'))>
                                <label class="form-check-label" for="createUser">
                                    Create
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'read-tickets')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox ticket-group" type="checkbox" id="readUser"  value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('read-tickets'))>
                                <label class="form-check-label" for="readUser">
                                    Read
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'update-tickets')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox ticket-group" type="checkbox" id="updateUser" value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('update-tickets'))>
                                <label class="form-check-label" for="updateUser">
                                    Update
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'delete-tickets')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox ticket-group" type="checkbox" id="deleteUser" value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('delete-tickets'))>
                                <label class="form-check-label" for="deleteUser">
                                    Delete
                                </label>
                            </td>
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#ticketModal">
                                <i class="bi bi-pencil-square"></i>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="ticketModal" tabindex="-1" aria-labelledby="ticketModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="ticketModalLabel">Other ticket</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @php
                                            $permission = $permissions->where('name', 'read-all-tickets')->first();
                                        @endphp
                                    <input class="form-check-input me-2 checkbox ticket-group" type="checkbox" id="readAllTicket" value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('read-all-tickets'))>
                                    <label class="form-check-label" for="readAllTicket">
                                        Read All Ticket
                                    </label>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </td>
                        </tr>
                        {{-- End Modul Ticket --}}

                        {{-- Modul Category --}}
                        <tr>
                            <td class="fw-bold">Category</td>
                            <td>
                                <input class="form-check-input me-2 checkbox checkAllCategory" type="checkbox" id="all-category" onclick="checkAllCategory(this)">
                                <label class="form-check-label" for="all-category">
                                    All Category
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'create-categories')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox category-group" type="checkbox" id="createCategory" value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('create-categories'))>
                                <label class="form-check-label" for="createCategory">
                                    Create
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'read-categories')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox category-group" type="checkbox" id="readCategory"  value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('read-categories'))>
                                <label class="form-check-label" for="readCategory">
                                    Read
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'update-categories')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox category-group" type="checkbox" id="updateCategory" value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('update-categories'))>
                                <label class="form-check-label" for="updateCategory">
                                    Update
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'delete-categories')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox category-group" type="checkbox" id="deleteCategory" value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('delete-categories'))>
                                <label class="form-check-label" for="deleteCategory">
                                    Delete
                                </label>
                            </td>
                            <td>
                                -
                            </td>
                        </tr>
                        {{-- End Modul Category --}}

                        {{-- Modul Unit --}}
                        <tr>
                            <td class="fw-bold">Unit</td>
                            <td>
                                <input class="form-check-input me-2 checkbox checkAllUnit" type="checkbox" id="all-unit" onclick="checkAllUnit(this)">
                                <label class="form-check-label" for="all-unit">
                                    All Unit
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'create-units')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox unit-group" type="checkbox" id="createUnit" value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('create-units'))>
                                <label class="form-check-label" for="createUnit">
                                    Create
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'read-units')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox unit-group" type="checkbox" id="readUnit"  value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('read-units'))>
                                <label class="form-check-label" for="readUnit">
                                    Read
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'update-units')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox unit-group" type="checkbox" id="updateUnit" value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('update-units'))>
                                <label class="form-check-label" for="updateUnit">
                                    Update
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'delete-units')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox unit-group" type="checkbox" id="deleteUnit" value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('delete-units'))>
                                <label class="form-check-label" for="deleteUnit">
                                    Delete
                                </label>
                            </td>
                            <td>
                                -
                            </td>
                        </tr>
                        {{-- End Modul Unit --}}

                        {{-- Modul User --}}
                        <tr>
                            <td class="fw-bold">User</td>
                            <td>
                                <input class="form-check-input me-2 checkbox checkAllUser" type="checkbox" id="all-user" onclick="checkAllUser(this)">
                                <label class="form-check-label" for="all-user">
                                    All User
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'create-users')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox user-group" type="checkbox" id="createUser" value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('create-users'))>
                                <label class="form-check-label" for="createUser">
                                    Create
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'read-users')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox user-group" type="checkbox" id="readUser"  value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('read-users'))>
                                <label class="form-check-label" for="readUser">
                                    Read
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'update-users')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox user-group" type="checkbox" id="updateUser" value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('update-users'))>
                                <label class="form-check-label" for="updateUser">
                                    Update
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'delete-users')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox user-group" type="checkbox" id="deleteUser" value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('delete-users'))>
                                <label class="form-check-label" for="deleteUser">
                                    Delete
                                </label>
                            </td>
                            <td>
                                -
                            </td>
                        </tr>
                        {{-- End Modul User --}}

                        {{-- Modul Role --}}
                        <tr>
                            <td class="fw-bold">Role</td>
                            <td>
                                <input class="form-check-input me-2 checkbox checkAllRole" type="checkbox" id="all-role" onclick="checkAllRole(this)">
                                <label class="form-check-label" for="all-role">
                                    All Role
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'create-roles')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox role-group" type="checkbox" id="createRole" value="{{ $permission->id }}"  name="permission[]" @checked($currentRole->hasPermissionTo('create-roles'))>
                                <label class="form-check-label" for="createRole">
                                    Create
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'read-roles')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox role-group" type="checkbox" id="readRole"  value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('read-roles'))>
                                <label class="form-check-label" for="readRole">
                                    Read
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'update-roles')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox role-group" type="checkbox" id="updateRole"  value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('update-roles'))>
                                <label class="form-check-label" for="updateRole">
                                    Update
                                </label>
                            </td>
                            <td>
                                @php
                                    $permission = $permissions->where('name', 'delete-roles')->first();
                                @endphp
                                <input class="form-check-input me-2 checkbox role-group" type="checkbox" id="deleteRole"  value="{{ $permission->id }}" name="permission[]" @checked($currentRole->hasPermissionTo('update-roles'))>
                                <label class="form-check-label" for="deleteRole">
                                    Delete
                                </label>
                            </td>
                            <td>
                                -
                            </td>
                        </tr>
                        {{-- End Modul Role --}}
                    </tbody>
                </table>
            </div>
        </form>
        <!-- end page main -->
    </div>
@endsection


@push('scripts')
    <script src="{{ asset('assets/js/sync-permission-role/sync.js') }}" defer></script>
@endpush
