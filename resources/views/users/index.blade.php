@extends('layouts.main')

@section('title', 'Users')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="card p-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Users</h4>
                <div class="page-title-right">
                    <a href="{{ route('users.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus me-2"></i> Create a user
                    </a>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- start page main -->
        <div class="card p-3">
            <table class="table">
                <thead>
                    <th>No</th>
                    <th>Image</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Is active?</th>
                    <th>Last login</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><img src="{{ asset('storage/'.$user->image) }}" alt=""></td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->is_active ? 'Active' : 'Non active' }}</td>
                            <td>{{ $user->last_login_at->diffForHumans()  }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    {{-- Detail Button --}}
                                    <a href="#" class="btn btn-sm btn-info" title="Show detail user">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    {{-- Edit Button --}}
                                    <a href="#" class="btn btn-sm btn-warning" title="Edit user">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    {{-- Deleten button --}}
                                    <a href="#" class="btn btn-sm btn-danger" title="Delete user">
                                        <i class="bi bi-trash3"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- end page main -->
    </div>
@endsection