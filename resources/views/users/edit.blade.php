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
                                   <input type="email" class="form-control" value="{{$user->email }}" id="email" disabled>
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
                        <i class="bi bi-person-lines-fill me-1"></i> General<span class="text-danger fst-italic">*</span>
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
                            <i class="bi bi-database-lock me-1"></i> Role<span class="text-danger fst-italic">*</span>
                    </button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContentUser">
                    {{-- Tab Additional --}}
                    <div class="tab-pane fade show active" id="general-tab-pane" role="tabpanel" aria-labelledby="general-tab" tabindex="0">
                        <div class="row py-4">
                            <div class="col-6">
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="phone" class="form-label">
                                            <i class="bi bi-telephone-forward me-2"></i> Phone
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', $user->profile->phone ?? '') }}">
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="mobile" class="form-label">
                                            <i class="bi bi-phone me-2"></i> Mobile
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="mobile" id="mobile" value="{{ old('mobile', $user->profile->mobile ?? '') }}">
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="address" class="form-label">
                                            <i class="bi bi-person-vcard me-2"></i> Address
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="address" id="address" value="{{ old('address', $user->profile->address ?? '') }}">
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="bio" class="form-label">
                                            <i class="bi bi-bookmark me-2"></i> Bio
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <textarea name="bio" id="bio" cols="30" rows="5" class="form-control">{{old('bio', $user->profile->bio ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="gender" class="form-label">
                                            <i class="bi bi-gender-ambiguous me-2"></i> Gender<span class="text-danger fst-italic">*</span>
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <select name="gender" id="gender" class="form-select">
                                            <option value="">Choose a one</option>
                                            <option value="1" @selected(old('gender', $user->profile->gender) == 1)>Laki-laki</option>
                                            <option value="0" @selected(old('gender', $user->profile->gender) == 0)>Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="place_of_birth" class="form-label">
                                            <i class="bi bi-globe-asia-australia me-2"></i> Place of Birth
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="place_of_birth" id="place_of_birth" value="{{ old('place_of_birth', $user->profile->place_of_birth ?? '') }}">
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="date_of_birth" class="form-label">
                                            <i class="bi bi-calendar3 me-2"></i> Date of Birth<span class="text-danger fst-italic">*</span>
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <input type="date" class="form-control" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $user->profile->date_of_birth ?? '') }}">
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="religion" class="form-label">
                                            <i class="bi bi-ui-radios me-2"></i> Religion<span class="text-danger fst-italic">*</span>
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <select name="religion" id="religion" class="form-select">
                                            <option value="">Choose a one</option>
                                            <option value="Islam" @selected(old('religion', $user->profile->religion)) == 'Islam')>Islam</option>
                                            <option value="Kristen" @selected(old('religion', $user->profile->religion)) == 'Kristen')>Kristen</option>
                                            <option value="Katolik" @selected(old('religion', $user->profile->religion)) == 'Katolik')>Katolik</option>
                                            <option value="Hindu" @selected(old('religion', $user->profile->religion)) == 'Hindu')>Hindu</option>
                                            <option value="Buddha" @selected(old('religion', $user->profile->religion)) == 'Buddha')>Buddha</option>
                                            <option value="Khonghucu" @selected(old('religion', $user->profile->religion)) == 'Khonghucu')>Khonghucu</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    {{-- Tab Media --}}
                    <div class="tab-pane fade" id="media-tab-pane" role="tabpanel" aria-labelledby="media-tab" tabindex="0">
                         <div class="row py-4">
                            <div class="col-6">
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="website" class="form-label">
                                            <i class="bi bi-globe me-2"></i> Website
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="website" id="website" value="{{ old('website', $user->profile->website ?? '') }}">
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="instagram" class="form-label">
                                            <i class="bi bi-instagram me-2"></i> Instagram
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="instagram" id="instagram" value="{{ old('instagram', $user->profile->instagram ?? '') }}">
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="facebook" class="form-label">
                                            <i class="bi bi-facebook me-2"></i> Facebook
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="facebook" id="facebook" value="{{ old('facebook', $user->profile->facebook ?? '') }}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="twitter" class="form-label">
                                            <i class="bi bi-twitter me-2"></i> Twitter
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="twitter" id="twitter" value="{{ old('twitter', $user->profile->twitter ?? '') }}">
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="youtube" class="form-label">
                                            <i class="bi bi-youtube me-2"></i> Youtube
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="youtube" id="youtube" value="{{ old('youtube', $user->profile->youtube ?? '') }}">
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-4">
                                        <label for="other" class="form-label">
                                            <i class="bi bi-three-dots me-2"></i> Other
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="other" id="other" value="{{ old('other', $user->profile->other ?? '') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tab Pane Homebase  --}}
                    <div class="tab-pane fade" id="homebase-tab-pane" role="tabpanel" aria-labelledby="homebase-tab" tabindex="0">
                        <div class="row  py-4 mb-3">
                            <div class="col-6">
                                <div class="row align-items-center">
                                    <label for="role" class="form-label col">
                                        <i class="bi bi-fingerprint me-2"></i> Role User<span class="fst-italic text-danger">*</span>
                                    </label>
                                    <select name="role" id="role" class="form-select col" required>
                                        <option value="">Choose one of the roles</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" @selected(isset($user->roles->pluck('name')[0]) == $role->name)>{{ $role->name }}</option>
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