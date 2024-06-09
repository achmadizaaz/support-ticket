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
                    {{-- Button kembali --}}
                    <a href="{{ route('users') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-bar-left me-2"></i> Back
                    </a>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- start page main -->
        <div class="card p-3">
            <form method="post" id="createForm">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-3 text-center">
                        <div class="mb-3">
                            <img src="https://st4.depositphotos.com/14953852/24787/v/1600/depositphotos_247872612-stock-illustration-no-image-available-icon-vector.jpg" alt="Upload a image" class="rounded-3" width="265px" height="300px" id="preview-image">
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
                                    <label for="name" class="form-label">Name<span class="fst-italic text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter name"  value="{{ old('name') }}" required>
                                </div>
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
                                <div class="mb-3">
                                    <label for="is_active" class="form-label">Is active?<span class="fst-italic text-danger">*</span></label>
                                    <select name="is_active" class="form-select" id="is_active" required>
                                        <option>Silakan pilih satu</option>
                                        <option value="0" @selected(old('is_active') == 0)>Non Active</option>
                                        <option value="1" @selected(old('is_active') == 1)>Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                
                                  
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password<span class="fst-italic text-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        <input type="password" class="form-control" name="password" placeholder="Enter password">
                                        <span class="input-group-text" id="showPassword">
                                            <i class="bi bi-eye-slash"></i>
                                        </span>
                                      </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role<span class="fst-italic text-danger">*</span></label>
                                    <select name="role" id="role" class="form-select">
                                        <option>Silakan pilih role pengguna</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col">
                        <div class="h4">Additional information</div>
                        <div class="row mb-4">
                            <label for="phone" class="col-sm-3 col-form-label">Phone</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="phone" name="phone">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="mobile" class="col-sm-3 col-form-label">Mobile</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="mobile" name="mobile">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="country" class="col-sm-3 col-form-label">Country</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="country" name="country">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="address" class="col-sm-3 col-form-label">Address</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="address" name="address">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea name="bio" id="bio" cols="30" rows="5" class="form-control">{{ old('bio') }}</textarea>
                        </div>
                    </div>
                    <div class="col">
                        <div class="h4">Media social</div>
                        <div class="row mb-4">
                            <label for="website" class="col-sm-3 col-form-label">Website</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="website" placeholder="www.example.com" name="website">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="instagram" class="col-sm-3 col-form-label">Instagram</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="instagram" placeholder="@example" name="instagram">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="facebook" class="col-sm-3 col-form-label">Facebook</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="facebook" placeholder="@example" name="facebook">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="twitter" class="col-sm-3 col-form-label">Twitter</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="twitter" placeholder="@example" name="twitter">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="youtube" class="col-sm-3 col-form-label">Youtube</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="youtube" placeholder="@example" name="youtube">
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