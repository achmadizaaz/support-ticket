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

        <!-- start alert -->
        {{-- Success --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Successfully</h4>
                <hr>
                <p class="mb-0">{{ session('success') }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Failed --}}
        @if (session('failed'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Failed</h4>
                <hr>
                <p class="mb-0">{{ session('failed') }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <!-- end alert -->

          {{-- Alert errors --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Errors:</h4>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        {{-- End Alert errors --}}

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
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">
                                @if (isset($user->image))
                                    <img src="{{ asset('storage/'.$user->image) }}" class="object-fit-cover border rounded-5" alt="{{ $user->username }}" height="40px" width="40px">
                                    @else
                                    <img src="{{ asset('assets/images/no-image.webp') }}" class="object-fit-cover border rounded-5"alt="{{ $user->username }}" height="40px" width="40px">
                                @endif
                            </td>
                            <td class="align-middle">{{ $user->username }}</td>
                            <td class="align-middle">{{ $user->name }}</td>
                            <td class="align-middle">{{ $user->email }}</td>
                            <td class="align-middle">{{ $user->is_active ? 'Active' : 'Non active' }}</td>
                            <td class="align-middle">{!! $user->last_login_at ? $user->last_login_at->diffForHumans() : '<span class="fst-italic">Belum pernah login</span>'  !!}</td>
                            <td class="align-middle">
                                <div class="d-flex gap-1">
                                    {{-- Detail Button --}}
                                    <a href="{{ route('users.show', $user->slug) }}" class="btn btn-sm btn-info" title="Show detail user">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    {{-- Edit Button --}}
                                    <a href="{{ route('users.edit', $user->slug) }}" class="btn btn-sm btn-warning" title="Edit user">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    {{-- Change password button --}}
                                    <button type="button" class="btn btn-sm btn-success changePasswordUser" data-bs-toggle="modal" data-bs-target="#changePasswordUserModal" data-username="{{ $user->username }}" data-id="{{ $user->id }}" title="Change password user">
                                        <i class="bi bi-shield-lock"></i>
                                    </button>

                                    {{-- Delete button --}}
                                    <button type="button" class="btn btn-sm btn-danger confirm_delete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-username="{{ $user->username }}" data-id="{{ $user->id }}" title="Delete user">
                                        <i class="bi bi-trash3"></i>
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- end page main -->
    </div>

    <!-- Modal Change password user -->
    <div class="modal fade" id="changePasswordUserModal" tabindex="-1" aria-labelledby="changePasswordUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="changePasswordUserModalLabel">Change Password: 
                    <span class="text-success changePasswordUserName"></span>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" id="formChangePassword" method="POST">
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <div class="mb-2">
                            Silakan masukan katasandi baru untuk pengguna: <span class="changePasswordUserName"></span>
                        </div>
                        <label for="changePasswordInput" class="form-label">
                            New Password
                        </label>
                        <input type="text" class="form-control" name="change_password" id="changePasswordInput" placeholder="Enter a new password" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Change Password.</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Delete user -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModalLabel">Delete User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" id="formDelete" method="POST">
                    <div class="modal-body">
                        @csrf
                        @method('DELETE')
                        <label for="confirm_delete" class="form-label">
                            Untuk melanjutkan penghapusan pengguna, silakan ketik: <span class="text-danger" id="modalUsername"></span>
                        </label>
                        <input type="text" class="form-control" name="confirm" id="confirm_delete" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-danger">Delete it.</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Change password
        $('.changePasswordUser').click(function(e) {
            let username = $(this).data('username');
            let id = $(this).data('id');
        
            $('.changePasswordUserName').html(username);
            
            // Route delete user
            let url = "{{ route('users.change.password', ':id') }}";
            route = url.replace(':id', id);
            // Action route for delete user
            $('#formChangePassword').attr('action', route);
        });

        // Delete user
        $('.confirm_delete').click(function(e) {
            let username = $(this).data('username');
            let id = $(this).data('id');
        
            $('#modalUsername').html(username);
            $('#confirm_delete').attr('placeholder', 'Ketikan: "'+username+'"')
            
            // Route delete user
            let url = "{{ route('users.delete', ':id') }}";
            route = url.replace(':id', id);
            // Action route for delete user
            $('#formDelete').attr('action', route);
        });
    </script>
@endpush