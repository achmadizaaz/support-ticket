@extends('layouts.main')

@section('title', $user->name)

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="card p-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ $user->name }}</h4>
                <div class="page-title-right d-flex gap-1">
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-warning">
                        <i class="bi bi-pencil-square me-2"></i> Edit
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

        <!-- start page main -->
        <div class="row">
            <div class="col-8">
                <div class="card p-3">
                    <div class="row mb-3">
                        <div class="col-md-3 text-center">
                            <div class="mb-3">
                                @if (isset($user->image))
                                    <img src="{{ asset('storage/'.$user->image) }}" alt="{{ $user->username }}" class="rounded-3 img-cover" width="200px" height="250px">
                                @else
                                    <img src="{{ asset('assets/images/no-image.webp') }}"alt="{{ $user->username }}" class="rounded-3 img-cover" width="200px" height="250px">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="mb-3">
                                        <h6>Username</h6>
                                        {{ $user->username }}
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <h6>Name</h6>
                                        {{ $user->name }}
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="mb-3">
                                        <h6>Email</h6>
                                        {{ $user->email }}
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <h6>Active?</h6>
                                        {{ $user->is_active ? 'Active' : 'Non active' }}
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="mb-3">
                                        <h6>Role</h6>
                                        {{ $user->roles->pluck('name') }}
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <h6>Last login at</h6>
                                        {!! $user->last_login_at ? $user->last_login_at->diffForHumans() : '<span class="fst-italic">Belum pernah login</span>'  !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="mb-3">
                                        <h6>Last login ip</h6>
                                        {!! $user->last_login_ip ?? '<span class="fst-italic">Belum pernah login</span>' !!}
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xl-6 col-md-12">
                            <div class="h4 py-2 border-bottom">Additional information</div>
                            <div class="row mb-4">
                                <label class="col-sm-4 col-form-label">
                                    <i class="bi bi-telephone me-2"></i> Phone
                                </label>
                                <div class="col-sm-8 col-form-label">
                                    {!! $user->additionalInformation->phone ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label class="col-sm-4 col-form-label">
                                    <i class="bi bi-phone me-2"></i> Mobile
                                </label>
                                <div class="col-sm-8 col-form-label">
                                    {!! $user->additionalInformation->mobile ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label class="col-sm-4 col-form-label">
                                    <i class="bi bi-flag me-2"></i> Country
                                </label>
                                <div class="col-sm-8 col-form-label">
                                    {!! $user->additionalInformation->country ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label class="col-sm-4 col-form-label">
                                    <i class="bi bi-person-vcard me-2"></i> Address
                                </label>
                                <div class="col-sm-8 col-form-label">
                                    {!! $user->additionalInformation->address ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">
                                    <i class="bi bi-bookmark me-2"></i> Bio
                                </label>
                                <div class="col-sm-8 col-form-label">
                                    {!! $user->additionalInformation->bio ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-12">
                            <div class="h4 py-2 border-bottom">Media social</div>
                            <div class="row mb-4">
                                <label class="col-sm-4 col-form-label">
                                    <i class="bi bi-globe me-2"></i> Website
                                </label>
                                <div class="col-sm-8 col-form-label">
                                    {!! $user->additionalInformation->website ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label class="col-sm-4 col-form-label">
                                    <i class="bi bi-instagram me-2"></i> Instagram
                                </label>
                                <div class="col-sm-8 col-form-label">
                                    {!! $user->additionalInformation->instagram ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label class="col-sm-4 col-form-label">
                                    <i class="bi bi-facebook me-2"></i> Facebook
                                </label>
                                <div class="col-sm-8 col-form-label">
                                    {!! $user->additionalInformation->facebook ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label class="col-sm-4 col-form-label">
                                    <i class="bi bi-twitter me-2"></i> Twitter
                                </label>
                                <div class="col-sm-8 col-form-label">
                                    {!! $user->additionalInformation->twitter ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label class="col-sm-4 col-form-label">
                                    <i class="bi bi-youtube me-2"></i> Youtube
                                </label>
                                <div class="col-sm-8 col-form-label">
                                    {!! $user->additionalInformation->youtube ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>Change Password</h5>
                        <hr>
                        <form action="{{ route('profile.change.password') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="password_current_user" class="form-label">Password current<span class="fst-italic text-danger">*</span></label>
                                <input type="password" class="form-control" name="current_password" id="password_current_user">
                            </div>
                            <div class="mb-3">
                                <label for="password_user" class="form-label">New Password<span class="fst-italic text-danger">*</span></label>
                                <input type="password" class="form-control" name="password" id="password_user">
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation_user" class="form-label">Password Confirmation<span class="fst-italic text-danger">*</span></label>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation_user">
                            </div>
                            <button type="submit" class="btn btn-outline-success">Save changes</button>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5>Delete account</h5>
                        <div class="mb-3 text-secondary">
                            Once you delete your account you cannot access the application
                        </div>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                            Delete account
                        </button>
                        <!-- Modal Delete Account -->
                        <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
                           <form action="{{ route('profile.delete') }}" method="POST">
                            @csrf
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h1 class="modal-title fs-5 text-danger" id="deleteAccountModalLabel">Delete Account</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                Are you sure you want to delete your account?
                                            </div>
                                            <input type="password" class="form-control" placeholder="Enter the current password" name="password">
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">Delete account</button>
                                        </div>
                                    </div>
                                </div>
                           </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page main -->
    </div>
@endsection