@extends('layouts.main')

@section('title', 'Users')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="card p-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Create a user</h4>
                <div class="page-title-right d-flex gap-1">
                    {{-- Button create user --}}
                    <button type="submit" class="btn btn-primary" form="createForm">
                        <i class="bi bi-save2 me-2"></i> Submit
                    </button>
                    {{-- Button reset user --}}
                    <button type="reset" class="btn btn-danger" form="createForm">
                        <i class="bi bi-arrow-clockwise me-2"></i> Reset
                    </button>
                    {{-- Button kembali --}}
                    <a href="{{ route('users') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-bar-left me-2"></i> Back
                    </a>
                </div>
            </div>
        </div>
        <!-- end page title -->

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
            <form method="POST" id="createForm" action="{{ route('users.store') }}" enctype= multipart/form-data>
                @csrf
                <div class="row mb-3">
                    <div class="col-md-3 text-center">
                        <div class="mb-3">
                            <img src="{{ asset('assets/images/no-image.webp') }}" alt="Upload a image" class="rounded-3 img-cover" width="100%" max-width="265%" height="100%" max-height="300px" id="preview-image">
                        </div>
                        <label for="uploadImage" class="btn btn-sm btn-info rounded-3 px-4">
                            <i class="bi bi-cloud-arrow-up me-2"></i> Upload a image
                        </label>
                        <input type="file" name="image" class="d-none" id="uploadImage" accept=".jpg,.jpeg,.png,.web">
                    </div>
                    <div class="col-md-9">
                        <div class="row mb-3">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username<span class="fst-italic text-danger">*</span></label>
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Enter username" value="{{ old('username') }}" autofocus required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password<span class="fst-italic text-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        <input type="password" class="form-control" name="password" placeholder="Enter password" required id="password">
                                        <span class="input-group-text" id="showPassword" onclick="showPasswordUser()">
                                            <i class="bi bi-eye-slash" id="icon-password-users"></i>
                                        </span>
                                      </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name<span class="fst-italic text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter name"  value="{{ old('name') }}" required>
                                </div>
                            </div>
                            
                            <div class="col">
                                <label for="role" class="form-label col">
                                    Role User<span class="fst-italic text-danger">*</span>
                                </label>
                                <select name="role" id="role" class="form-select col" required>
                                    <option value="">Choose one of the roles</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" @selected(old('role') == $role->id)>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
        
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email<span class="fst-italic text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email, ex: your@example.com"  value="{{ old('email') }}"  required>
                                </div>
                            </div>
                            <div class="col">
                                <label for="homebase" class="form-label">Homebase</label>
                                <select name="homebase" id="homebase" class="form-select">
                                    <option value="">Choose one of the homebases</option>
                                    @foreach ($homebases as $homebase)
                                        <option value="{{ $homebase->id }}" @selected(old('homebase') == $homebase->id)>{{ $homebase->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone') }}">
                            </div>
                        </div>
                        
                    </div>
                </div>
            </form>
        </div>
        <!-- end page main -->
    </div>
@endsection

@push('scripts')
<script>
    // PREVIEW IMAGE
    $('#uploadImage').change(function(){
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#preview-image').attr('src', e.target.result); 
        }
        reader.readAsDataURL(this.files[0]); 
    });

    // Show / hide password
    function showPasswordUser() {
        let iconPasswordUsers = document.getElementById("icon-password-users");
        let password = document.getElementById("password");
        // If click icon password, 
        // check type password and change type password
        if(password.type == 'password'){
            iconPasswordUsers.classList.remove('bi-eye-slash');
            iconPasswordUsers.classList.add('bi-eye');
            password.type = "text";
        }else{
            iconPasswordUsers.classList.remove('bi-eye');
            iconPasswordUsers.classList.add('bi-eye-slash');
            password.type = "password";
        }
    };

</script>
@endpush