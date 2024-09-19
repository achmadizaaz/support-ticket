@extends('layouts.main')

@section('title', 'Edit User: '.$user->name)

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="card p-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Edit {{ $user->name }}</h4>
                <div class="page-title-right d-flex gap-1">
                    {{-- Button update user --}}
                    <button type="submit" class="btn btn-warning" form="updateForm">
                        <i class="bi bi-pencil-square me-2"></i> Update
                    </button>
                    {{-- Button kembali --}}
                    <a href="{{ route('users.show', $user->slug) }}" class="btn btn-secondary">
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
            <form method="post" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data"  id="updateForm">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <div class="col-md-3 text-center">
                        <div class="mb-3">
                           @if (isset($user->image))
                            <img src="{{ asset('storage/'.$user->image) }}" alt="Upload a image" class="rounded-3 img-cover" width="100%" max-width="265%" height="100%" max-height="300px" id="preview-image">
                           @else
                            <img src="{{ asset('assets/images/no-image.webp') }}" alt="Upload a image" class="rounded-3 img-cover" width="100%" max-width="265%" height="100%" max-height="300px" id="preview-image">
                           @endif
                        </div>
                        <label for="uploadImage" class="btn btn-sm btn-info rounded-3 px-4">
                            <i class="bi bi-cloud-arrow-up me-2"></i> Upload a image
                        </label>
                        <input type="file" name="image" class="d-none" id="uploadImage" accept=".jpg,.jpeg,.png,.web">
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col">
                                <div class="mb-4">
                                   <label for="username" class="form-label">Username <span class="text-danger fst-italic">*</span></label>
                                   <input type="text" name="username" class="form-control" id="username" value="{{ old('username', $user->username) }}">
                                </div>
                                <div class="mb-4">
                                    <label for="name" class="form-label">Name <span class="text-danger fst-italic">*</span></label>
                                   <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $user->name) }}">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="email">Email</label>
                                   <input type="email" name="email" class="form-control" value="{{ $user->email }}" id="email">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="phone">Phone</label>
                                   <input type="text" class="form-control" value="{{ $user->phone }}" id="phone">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-4">
                                    <label for="is_active" class="form-label">Active?<span class="fst-italic text-danger">*</span></label>
                                    <select name="is_active" class="form-select" id="is_active" required>
                                        <option>Silakan pilih satu</option>
                                        <option value="0" @selected(old('is_active', $user->is_active) == 0)>Non Active</option>
                                        <option value="1" @selected(old('is_active', $user->is_active) == 1)>Active</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="role" class="form-label">Role</label>
                                    <select name="role" id="role" class="form-select">
                                        <option value="">Pilih role pengguna</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" @selected($role->id == $user->roles->pluck('id')[0] ??'')>{{ $role->name }}</option>
                                        @endforeach                                
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="homebase" class="form-label">Homebase</label>
                                    <select name="homebase" id="homebase" class="form-select">
                                        <option value="">Pilih homebase</option>
                                        @foreach ($homebases as $homebase)
                                            <option value="{{ $homebase->id }}" @selected(old('homebase', $user->unit_id) == $homebase->id)>{{ $homebase->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
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
</script>
@endpush