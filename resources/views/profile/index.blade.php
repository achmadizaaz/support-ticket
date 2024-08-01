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
                                        <h6>Active</h6>
                                        @if ($user->is_active)
                                            <div class="badge text-bg-success">Active</div>
                                            @else
                                            <div class="badge text-bg-warning">Non active</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-4">
                                        <h6>Last login at</h6>
                                        {!! $user->last_login_at ? $user->last_login_at->diffForHumans() : '<span class="fst-italic">Belum pernah login</span>'  !!}
                                    </div>
                                    <div class="mb-4">
                                        <h6>Last login ip</h6>
                                        {!! $user->last_login_ip ?? '<span class="fst-italic">Belum pernah login</span>' !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <ul class="nav nav-tabs" id="myTabUser" role="tablist">
                        {{-- For tab General --}}
                        <li class="nav-item py-2" role="presentation">
                          <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general-tab-pane" type="button" role="tab" aria-controls="general-tab-pane" aria-selected="true">
                            <i class="bi bi-person-lines-fill me-1"></i> General
                          </button>
                        </li>
                        {{-- For tab media social --}}
                        <li class="nav-item py-2" role="presentation">
                          <button class="nav-link" id="media-tab" data-bs-toggle="tab" data-bs-target="#media-tab-pane" type="button" role="tab" aria-controls="media-tab-pane" aria-selected="false">
                            <i class="bi bi-globe me-1"></i>  Media Social
                        </button>
                        </li>
                        {{-- For tab homebase --}}
                        <li class="nav-item py-2" role="presentation">
                            <button class="nav-link" id="homebase-tab" data-bs-toggle="tab" data-bs-target="#homebase-tab-pane" type="button" role="tab" aria-controls="homebase-tab-pane" aria-selected="false">
                                <i class="bi bi-database-lock me-1"></i> Role
                        </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContentUser">
                        {{-- Tab Additional --}}
                        <div class="tab-pane fade show active" id="general-tab-pane" role="tabpanel" aria-labelledby="general-tab" tabindex="0">
                            <div class="row py-4">
                                <div class="col-6">
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-4">
                                            <i class="bi bi-telephone-forward me-2"></i> Phone
                                        </div>
                                        <div class="col-8">
                                            {{ $user->profile->phone ?? 'Tidak tersedia' }}
                                        </div>
                                    </div>
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-4">
                                            <i class="bi bi-phone me-2"></i> Mobile
                                        </div>
                                        <div class="col-8">
                                            {{ $user->profile->mobile ?? 'Tidak tersedia' }}
                                        </div>
                                    </div>
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-4">
                                            <i class="bi bi-person-vcard me-2"></i> Address
                                        </div>
                                        <div class="col-8">
                                            {{ $user->profile->address ?? 'Tidak tersedia' }}
                                        </div>
                                    </div>
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-4">
                                            <i class="bi bi-bookmark me-2"></i> Bio
                                        </div>
                                        <div class="col-8">
                                            {{ $user->profile->bio ?? 'Tidak tersedia' }}
                                        </div>
                                    </div>
                                </div>
        
                                <div class="col-6">
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-4">
                                            <i class="bi bi-gender-ambiguous me-2"></i> Gender
                                        </div>
                                        <div class="col-8">
                                            @if (isset($user->profile->gender) == 'man')
                                                Laki-laki
                                                @else
                                                Perempuan
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-4">
                                            <i class="bi bi-globe-asia-australia me-2"></i> Place of Birth
                                        </div>
                                        <div class="col-8">
                                            {{ $user->profile->place_of_birth ?? 'Tidak tersedia' }}
                                        </div>
                                    </div>
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-4">
                                            <i class="bi bi-calendar3 me-2"></i> Date of Birth
                                        </div>
                                        <div class="col-8">
                                            {{ $user->profile->date_of_birth ?? 'Tidak tersedia' }}
                                        </div>
                                    </div>
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-4">
                                            <i class="bi bi-ui-radios me-2"></i> Religion
                                        </div>
                                        <div class="col-8">
                                            {{ $user->profile->religion ?? 'Tidak tersedia' }}
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        {{-- Tab Media --}}
                        <div class="tab-pane fade" id="media-tab-pane" role="tabpanel" aria-labelledby="media-tab" tabindex="0">
                             <div class="row py-4">
                                <div class="col-6">
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-4">
                                            <i class="bi bi-globe me-2"></i> Website
                                        </div>
                                        <div class="col-8">
                                            {{ $user->profile->website ?? 'Tidak tersedia' }}
                                        </div>
                                    </div>
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-4">
                                            <i class="bi bi-instagram me-2"></i> Instagram
                                        </div>
                                        <div class="col-8">
                                            {{ $user->profile->instagram ?? 'Tidak tersedia' }}
                                        </div>
                                    </div>
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-4">
                                            <i class="bi bi-facebook me-2"></i> Facebook
                                        </div>
                                        <div class="col-8">
                                            {{ $user->profile->facebook ?? 'Tidak tersedia' }}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-6">
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-4">
                                            <i class="bi bi-twitter me-2"></i> Twitter
                                        </div>
                                        <div class="col-8">
                                            {{ $user->profile->twitter ?? 'Tidak tersedia' }}
                                        </div>
                                    </div>
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-4">
                                            <i class="bi bi-youtube me-2"></i> Youtube
                                        </div>
                                        <div class="col-8">
                                            {{ $user->profile->youtube ?? 'Tidak tersedia' }}
                                        </div>
                                    </div>
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-4">
                                            <i class="bi bi-three-dots me-2"></i> Other
                                        </div>
                                        <div class="col-8">
                                            {{ $user->profile->other ?? 'Tidak tersedia' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        {{-- Tab Pane Homebase  --}}
                        <div class="tab-pane fade" id="homebase-tab-pane" role="tabpanel" aria-labelledby="homebase-tab" tabindex="0">
                            <div class="row  py-4 mb-3">
                                <div class="col-2">
                                    <i class="bi bi-fingerprint me-2"></i> Role User
                                </div>
                                <div class="col-10">
                                    {{ $user->roles->pluck('name') }}
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
                            <button type="submit" class="btn btn-outline-success" id="changePassword" disabled>Save changes</button>
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

@push('scripts')
    <script>
        // For change disable submit "Change Password"
        const currentPassword = document.getElementById('password_current_user');
        const newPassword = document.getElementById('password_user');
        const confirmPassword = document.getElementById('password_confirmation_user');
        const submitBtn = document.getElementById('changePassword');

        // Fungsi untuk memeriksa input field
        function checkInputs() {
            if (currentPassword.value && newPassword.value && confirmPassword.value) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('btn-outline-secondary');
                submitBtn.classList.add('btn-outline-success');
            } else {
                submitBtn.disabled = true;
                submitBtn.classList.remove('btn-outline-success');
                submitBtn.classList.add('btn-outline-secondary');
            }
        }

        // Menambahkan event listener untuk memonitor perubahan pada input field
        currentPassword.addEventListener('input', checkInputs);
        newPassword.addEventListener('input', checkInputs);
        confirmPassword.addEventListener('input', checkInputs);
    </script>
@endpush