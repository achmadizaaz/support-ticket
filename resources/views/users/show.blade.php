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
                                        <label class="form-label">
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
            <ul class="nav nav-tabs" id="myTabUser" role="tablist">
                {{-- For tab additional --}}
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="additional-tab" data-bs-toggle="tab" data-bs-target="#additional-tab-pane" type="button" role="tab" aria-controls="additional-tab-pane" aria-selected="true">
                    <i class="bi bi-person-vcard"></i> Additional
                  </button>
                </li>
                {{-- For tab media social --}}
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="media-tab" data-bs-toggle="tab" data-bs-target="#media-tab-pane" type="button" role="tab" aria-controls="media-tab-pane" aria-selected="false">
                    <i class="bi bi-globe"></i>  Media Social
                </button>
                </li>
                {{-- For tab contact --}}
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">
                    <i class="bi bi-person-lines-fill"></i> Contact
                </button>
                </li>
                {{-- For tab homebase --}}
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="homebase-tab" data-bs-toggle="tab" data-bs-target="#homebase-tab-pane" type="button" role="tab" aria-controls="homebase-tab-pane" aria-selected="false">
                    <i class="bi bi-house"></i> Homebase
                </button>
                </li>
              </ul>
            <div class="tab-content" id="myTabContentUser">
                {{-- Tab Additional --}}
                <div class="tab-pane fade show active" id="additional-tab-pane" role="tabpanel" aria-labelledby="additional-tab" tabindex="0">
                    <div class="row">
                        <div class="col-xl-6 col-md-12">
                            <div class="h4 py-2 border-bottom">Additional information</div>
                            <div class="row mb-4">
                                <label class="col-sm-3 col-form-label">
                                    <i class="bi bi-telephone me-2"></i> Phone
                                </label>
                                <div class="col-sm-9 col-form-label">
                                    {!! $user->additionalInformation->phone ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label class="col-sm-3 col-form-label">
                                    <i class="bi bi-phone me-2"></i> Mobile
                                </label>
                                <div class="col-sm-9 col-form-label">
                                    {!! $user->additionalInformation->mobile ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label class="col-sm-3 col-form-label">
                                    <i class="bi bi-flag me-2"></i> Country
                                </label>
                                <div class="col-sm-9 col-form-label">
                                    {!! $user->additionalInformation->country ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label class="col-sm-3 col-form-label">
                                    <i class="bi bi-person-vcard me-2"></i> Address
                                </label>
                                <div class="col-sm-9 col-form-label">
                                    {!! $user->additionalInformation->address ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">
                                    <i class="bi bi-bookmark me-2"></i> Bio
                                </label>
                                <div class="col-sm-9 col-form-label">
                                    {!! $user->additionalInformation->bio ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Tab Media --}}
                <div class="tab-pane fade" id="media-tab-pane" role="tabpanel" aria-labelledby="media-tab" tabindex="0">
                    <div class="row p-2">
                        <div class="col-6">
                            <div class="row mb-2">
                                <label class="col-sm-3 col-form-label">
                                    <i class="bi bi-globe me-2"></i> Website
                                </label>
                                <div class="col-sm-9 col-form-label">
                                    {!! $user->additionalInformation->website ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-3 col-form-label">
                                    <i class="bi bi-instagram me-2"></i> Instagram
                                </label>
                                <div class="col-sm-9 col-form-label">
                                    {!! $user->additionalInformation->instagram ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-3 col-form-label">
                                    <i class="bi bi-facebook me-2"></i> Facebook
                                </label>
                                <div class="col-sm-9 col-form-label">
                                    {!! $user->additionalInformation->facebook ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row mb-2">
                                <label class="col-sm-3 col-form-label">
                                    <i class="bi bi-twitter me-2"></i> Twitter
                                </label>
                                <div class="col-sm-9 col-form-label">
                                    {!! $user->additionalInformation->twitter ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-3 col-form-label">
                                    <i class="bi bi-youtube me-2"></i> Youtube
                                </label>
                                <div class="col-sm-9 col-form-label">
                                    {!! $user->additionalInformation->youtube ?? '<span class="fst-italic">Tidak tersedia</span>' !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">...</div>
                <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">...</div>
            </div>
        </div>
        <!-- end page main -->
    </div>
@endsection