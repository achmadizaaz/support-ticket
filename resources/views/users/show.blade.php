@extends('layouts.main')

@section('title', 'Users')

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
                                <form action="{{ route('users.delete', $user->slug) }}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="deleteModalLabel">Delete: {{ $user->name }}</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <label for="confirm" class="form-label">
                                            Untuk melanjutkan penghapusan pengguna, silakan ketik: <span class="fst-italic text-danger">{{ $user->username }}</span>
                                        </label>
                                        <input type="text" class="form-control" name="confirm" placeholder="Enter confirmation: {{ $user->username }}">
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
        @if (session('failed'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i> {{ session('failed') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <!-- end alert -->

        <!-- start page main -->
        <div class="card p-3">
            <form method="post" id="createForm">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-3 text-center">
                        <div class="mb-3">
                            <img src="{{ asset('assets/images/no-image.webp') }}" alt="Upload a image" class="rounded-3 img-cover" width="265px" height="300px" id="preview-image">
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
                                    {{-- {{ $user->roles->pluck('name')[0] }} --}}
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
                            <label for="phone" class="col-sm-3 col-form-label">
                                <i class="bi bi-telephone me-2"></i> Phone
                            </label>
                            <div class="col-sm-9 col-form-label">
                                {!! $user->addtionalInformation->phone ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="mobile" class="col-sm-3 col-form-label">
                                <i class="bi bi-phone me-2"></i> Mobile
                            </label>
                            <div class="col-sm-9 col-form-label">
                                {!! $user->addtionalInformation->mobile ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="country" class="col-sm-3 col-form-label">
                                <i class="bi bi-flag me-2"></i> Country
                            </label>
                            <div class="col-sm-9 col-form-label">
                                {!! $user->addtionalInformation->country ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="address" class="col-sm-3 col-form-label">
                                <i class="bi bi-person-vcard me-2"></i> Address
                            </label>
                            <div class="col-sm-9 col-form-label">
                                {!! $user->addtionalInformation->address ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="bio" class="col-sm-3 col-form-label">
                                <i class="bi bi-bookmark me-2"></i> Bio
                            </label>
                            <div class="col-sm-9 col-form-label">
                                {!! $user->addtionalInformation->bio ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-12">
                        <div class="h4 py-2 border-bottom">Media social</div>
                        <div class="row mb-4">
                            <label for="website" class="col-sm-3 col-form-label">
                                <i class="bi bi-mask me-2"></i> Website
                            </label>
                            <div class="col-sm-9 col-form-label">
                                {!! $user->addtionalInformation->website ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="instagram" class="col-sm-3 col-form-label">
                                <i class="bi bi-instagram me-2"></i> Instagram
                            </label>
                            <div class="col-sm-9 col-form-label">
                                {!! $user->addtionalInformation->instagram ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="facebook" class="col-sm-3 col-form-label">
                                <i class="bi bi-facebook me-2"></i> Facebook
                            </label>
                            <div class="col-sm-9 col-form-label">
                                {!! $user->addtionalInformation->facebook ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="twitter" class="col-sm-3 col-form-label">
                                <i class="bi bi-twitter me-2"></i> Twitter
                            </label>
                            <div class="col-sm-9 col-form-label">
                                {!! $user->addtionalInformation->twitter ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="youtube" class="col-sm-3 col-form-label">
                                <i class="bi bi-youtube me-2"></i> Youtube
                            </label>
                            <div class="col-sm-9 col-form-label">
                                {!! $user->addtionalInformation->youtube ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
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