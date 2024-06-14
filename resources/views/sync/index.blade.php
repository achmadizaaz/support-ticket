@extends('layouts.main')

@section('title', 'Sync Permission')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="card p-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Sync Permission</h4>
                <div class="page-title-right">
                    <div class="page-title-right">
                        <button type="button" class="btn btn-primary" disabled>
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
                <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
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
        @include('sync.components.change-role')
        {{-- END Change Role --}}

        <div class="card p-3">
            <table class="table">
                <thead>
                    <th>Modul</th>
                    <th>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="checkAll">
                            <label class="form-check-label" for="checkAll">
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
                            <input class="form-check-input me-2" type="checkbox" id="checkUser">
                            <label class="form-check-label" for="checkUser">
                                All User
                            </label>
                        </td>
                        <td>
                            <input class="form-check-input me-2" type="checkbox" id="createUser">
                            <label class="form-check-label" for="createUser">
                                Create
                            </label>
                        </td>
                        <td>
                            <input class="form-check-input me-2" type="checkbox" id="readUser">
                            <label class="form-check-label" for="readUser">
                                Read
                            </label>
                        </td>
                        <td>
                            <input class="form-check-input me-2" type="checkbox" id="updateUser">
                            <label class="form-check-label" for="updateUser">
                                Update
                            </label>
                        </td>
                        <td>
                            <input class="form-check-input me-2" type="checkbox" id="deleteUser">
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
                            <input class="form-check-input me-2" type="checkbox" id="checkRole">
                            <label class="form-check-label" for="checkRole">
                                All Role
                            </label>
                        </td>
                        <td>
                            <input class="form-check-input me-2" type="checkbox" id="createRole">
                            <label class="form-check-label" for="createRole">
                                Create
                            </label>
                        </td>
                        <td>
                            <input class="form-check-input me-2" type="checkbox" id="readRole">
                            <label class="form-check-label" for="readRole">
                                Read
                            </label>
                        </td>
                        <td>
                            <input class="form-check-input me-2" type="checkbox" id="updateRole">
                            <label class="form-check-label" for="updateRole">
                                Update
                            </label>
                        </td>
                        <td>
                            <input class="form-check-input me-2" type="checkbox" id="deleteRole">
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
        <!-- end page main -->
    </div>
@endsection

