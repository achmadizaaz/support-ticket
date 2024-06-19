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
