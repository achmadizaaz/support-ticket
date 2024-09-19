@extends('layouts.main')

@section('title', $user->name)

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="card p-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ $user->name }}</h4>
                <div class="page-title-right d-flex gap-1">

                    {{-- Button Delete --}}
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="bi bi-trash3 me-2"></i> Delete
                    </button>

                    <!-- Start Delete Modal -->
                    <div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('users.delete', $user->id) }}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="deleteModalLabel">Delete: {{ $user->name }}</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <label class="form-label" for="confirm-delete">
                                            Untuk melanjutkan penghapusan pengguna, silakan ketik: <span class="fst-italic text-danger">{{ $user->username }}</span>
                                        </label>
                                        <input type="text" class="form-control" name="confirm" placeholder="Enter confirmation: {{ $user->username }}" id="confirm-delete">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">Delete it.</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                     <!-- END Delete Modal -->
                
                    {{-- Button Edit --}}
                    <a href="{{ route('users.edit', $user->slug) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square me-2"></i> Edit
                    </a>

                    {{-- Button kembali --}}
                    <a href="{{ route('users') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-bar-left me-2"></i> Back
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

        <!-- start page main -->
        <div class="card p-3">
            <div class="row mb-3">
                <div class="col-md-3 text-center">
                    <div class="mb-3">
                        @if (isset($user->image))
                            <img src="{{ asset('storage/'.$user->image) }}" alt="{{ $user->username }}" class="rounded-3 img-cover" width="100%" max-width="265%" height="100%" max-height="300px">
                        @else
                            <img src="{{ asset('assets/images/no-image.webp') }}"alt="{{ $user->username }}" class="rounded-3 img-cover" width="100%" max-width="265%" height="100%" max-height="300px">
                        @endif
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col">
                            <div class="mb-4">
                                <h6>Username</h6>
                                {{ $user->username }}
                            </div>
                            <div class="mb-4">
                                <h6>Name</h6>
                                {{ $user->name }}
                            </div>
                            <div class="mb-4">
                                <h6>Email</h6>
                                {{ $user->email }}
                            </div>
                            <div class="mb-4">
                                <h6>Phone</h6>
                                {{ $user->phone ?? '-' }}
                            </div>
                            <div class="mb-4">
                                <h6>Active</h6>
                                @if ($user->is_active)
                                    <div class="badge bg-success">Active</div>
                                    @else
                                    <div class="badge bg-warning">Non active</div>
                                @endif
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-4">
                                <h6>Role</h6>
                                {{ $user->roles->pluck('name')[0] }}
                            </div>
                            <div class="mb-4">
                                <h6>Last login at</h6>
                                {!! $user->last_login_at ? $user->last_login_at->diffForHumans() : '<span class="fst-italic">Belum pernah login</span>'  !!}
                            </div>
                            <div class="mb-4">
                                <h6>Last login ip</h6>
                                {!! $user->last_login_ip ?? '<span class="fst-italic">Belum pernah login</span>' !!}
                            </div>
                            <div class="mb-4">
                                <h6>Homebase</h6>
                                {{ $user->homebase->name ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- end page main -->
    </div>
@endsection