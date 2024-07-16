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
                        <div class="row mb-3">
                            <div class="col-md-12 col-xl-6">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username<span class="fst-italic text-danger">*</span></label>
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Enter username" value="{{ old('username', $user->username) }}" autofocus required>
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name<span class="fst-italic text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter name"  value="{{ old('name', $user->name) }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12 col-xl-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email<span class="fst-italic text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email, ex: your@example.com"  value="{{ old('email', $user->email) }}"  required>
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-6">
                                <div class="mb-3">
                                    <label for="is_active" class="form-label">Is active?<span class="fst-italic text-danger">*</span></label>
                                    <select name="is_active" class="form-select" id="is_active" required>
                                        <option>Silakan pilih satu</option>
                                        <option value="0" @selected(old('is_active', $user->is_active) == 0)>Non Active</option>
                                        <option value="1" @selected(old('is_active', $user->is_active) == 1)>Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12 col-xl-6">
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role<span class="fst-italic text-danger">*</span></label>
                                    <select name="role" id="role" class="form-select">
                                        <option>Silakan pilih role pengguna</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" @selected($user->roles->pluck('name')[0] == $role->name)>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
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
                            <label for="phone" class="col-sm-3 col-form-label">Phone</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->additionalInformation->phone ?? '') }}" placeholder="Enter phone ex: 021 123456">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="mobile" class="col-sm-3 col-form-label">Mobile</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="mobile" name="mobile" value="{{ old('mobile', $user->additionalInformation->mobile ?? '') }}" placeholder="Enter mobile ex: 08123456789">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="country" class="col-sm-3 col-form-label">Country</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="country" name="country" value="{{ old('country', $user->additionalInformation->country ?? '') }}" placeholder="Enter country">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="address" class="col-sm-3 col-form-label">Address</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $user->additionalInformation->address ?? '') }}" placeholder="Enter address">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea name="bio" id="bio" cols="30" rows="5" class="form-control">{{ old('bio', $user->additionalInformation->bio ?? '') }}</textarea>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-12">
                        <div class="h4 py-2 border-bottom">Media social</div>
                        <div class="row mb-4">
                            <label for="website" class="col-sm-3 col-form-label">Website</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="website" placeholder="www.example.com" name="website" value="{{ old('website', $user->additionalInformation->website ?? '') }}">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="instagram" class="col-sm-3 col-form-label">Instagram</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="instagram" placeholder="instagram.com/example" name="instagram" value="{{ old('instagram', $user->additionalInformation->instagram ?? '') }}">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="facebook" class="col-sm-3 col-form-label">Facebook</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="facebook" placeholder="facebook.com/example" name="facebook" value="{{ old('facebook', $user->additionalInformation->facebook ?? '') }}">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="twitter" class="col-sm-3 col-form-label">Twitter</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="twitter" placeholder="twitter.com/example" name="twitter" value="{{ old('twitter', $user->additionalInformation->twitter ?? '') }}">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="youtube" class="col-sm-3 col-form-label">Youtube</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="youtube" placeholder="youtube.com/example" name="youtube" value="{{ old('youtube', $user->additionalInformation->youtube ?? '') }}">
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