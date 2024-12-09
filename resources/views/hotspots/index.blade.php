@extends('layouts.main')

@section('title', 'Hotspot')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="card p-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Hotspot Management</h4>
                <div class="page-title-right">
                    <div class="page-title-right">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                            <i class="bi bi-plus me-2"></i>Create a permission
                        </button>

                        <!-- Modal Create Permission -->
                        <div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('hotspot.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="createRoleModalLabel">Request Hotspot</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-primary text-center mb-3" role="alert">
                                                Silakan masukkan akun hotspot Anda
                                            </div>
                                            @if (Auth::user()->roles->max('is_admin') == 1)
                                                <div class="mb-3">
                                                    <label for="user">User</label>
                                                    <select name="user" id="user" class="form-select">
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endif
                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <label for="name" class="form-lavel">Username <span class="text-danger fst-italic">*</span></label>
                                                    <input type="text" class="form-control" name="username" placeholder="Username hotspot Anda" value="{{ Auth::user()->username }}" required>
                                                </div>
                                                <div class="col-6">
                                                    <label for="password" class="form-lavel">Password <span class="text-danger fst-italic">*</span></label>
                                                    <input type="text" class="form-control" name="password" placeholder="Katasandi hotspot Anda" value="{{ old('password') }}" required>
                                                </div>
                                            </div>
                                            @if (Auth::user()->roles->max('is_admin') == 1)
                                               <div class="row mb-3">
                                                    <div class="col-6">
                                                        <label for="status" class="form-label">Status</label>
                                                        <select name="status" id="statuses" class="form-select">
                                                            <option value="pending">Pending</option>
                                                            <option value="approved">Approved</option>
                                                            <option value="rejected">Rejected</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="user_profil" class="form-label">User Profiles <span class="text-danger fst-italic">*</span></label>
                                                        <select name="user_profile" id="user_profiles" class="form-select" required>
                                                            <option value="mahasiswa">Mahasiswa</option>
                                                            <option value="karyawan">Karyawan</option>
                                                            <option value="dosen">Dosen</option>
                                                        </select>
                                                    </div>
                                               </div>
                                            @endif
                                            <hr>
                                            <div class="mb-2 text-info">
                                                Mohon lengkapi data diri Anda di bawah ini sesuai dengan data yang tercatat di Sistem Akademik (Siakad).
                                            </div>
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Nama Lengkap</label>
                                                <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap" value="{{ Auth::user()->name }}" required>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                                    <input type="date" name="tanggal_lahir" class="form-control" id="tanggal_lahir" required>
                                                </div>
                                                <div class="col-6">
                                                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                                    <input type="text" name="tempat_lahir" class="form-control" id="tempat_lahir" placeholder="Tempat Lahir Anda" required>
                                                </div>
                                            </div>
                                            <div class="small fst-italic text-danger">
                                                ** Data yang tidak sesuai dengan siakad akan kami tolak.
                                            </div>
                                            
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">
                                                Submit
                                            </button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Close
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="alert alert-warning" role="alert">
            <h4 class="alert-heading">Alert</h4>
            <hr>
            <p class="mb-0">Fitur ini masih dalam tahap pengembangan.</p>
        </div>


        <!-- Alert  -->
        {{-- Alert Success --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        {{-- Alert Failed --}}
        @if (session('failed'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i> {{ session('failed') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
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
        <!-- end Alert -->

        <!-- start page main -->
        <div class="card p-3">
            <div class="d-flex justify-content-between mb-2">
               <div class="d-flex gap-1">
                    {{-- Input Pencarian --}}
                    <form action="{{ route('permissions')}}" method="GET" class="d-flex gap-1">
                        <input type="text" name="search" class="form-control"  placeholder="Searching" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>

                    {{-- Button Reset --}}
                    <a href="{{ route('permissions') }}" class="btn btn-info text-white" title="Reset">
                        <i class="bi bi-circle"></i>
                    </a>
               </div>
            </div>
           <div class="table-responsive">
            <table class="table">
                <thead>
                    <th>No</th>
                    <th>Pengguna</th>
                    <th>Hotspot</th>
                    <th>Katasandi</th>
                    <th class="text-center">Verify Data</th>
                    <th>Status</th>
                    <th>Role</th>
                    <th>Created at</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach ($hotspots as $hotspot)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $hotspot->user->username }}</td>
                            <td>{{ $hotspot->username }}</td>
                            <td>{{ $hotspot->password }}</td>
                            <td class="text-center">
                                @if ($hotspot->verify && $hotspot->status != 'approved')
                                    <button type="button" class="btn btn-sm btn-info verify" data-bs-toggle="modal" data-bs-target="#verifyModal" data-id="{{ $hotspot->id }}"  data-status="{{ $hotspot->status }}" data-nama="{{ json_decode($hotspot->verify)->nama_lengkap ?? 'tidak ada' }}"  data-lahir="{{ json_decode($hotspot->verify)->tanggal_lahir ?? 'tidak ada' }}" data-tempat_lahir="{{ json_decode($hotspot->verify)->tempat_lahir ?? 'tidak ada' }}">
                                        <i class="bi bi-info-circle"></i>
                                    </button>
                                @endif

                                @if ($hotspot->verify && $hotspot->status == 'approved')
                                    <span class="text-success fst-italic">Verified</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2 align-items-center">
                                    <div>
                                        {{ $hotspot->status }}
                                    </div>
    
                                    @if ($hotspot->verify && $hotspot->status == 'rejected')
                                        <button type="button" class="btn btn-sm btn-danger rejected" data-bs-toggle="modal" data-bs-target="#rejectedModal" data-id="{{ $hotspot->id }}"  data-reasons="{{ $hotspot->reasons ?? 'Tidak ada'}}">
                                            <i class="bi bi-info-circle"></i>
                                        </button>
                                    @endif 
                                </div>
                            </td>
                            <td>{{ $hotspot->user->roles->pluck('name')[0] }}</td>
                            <td>{{ $hotspot->created_at }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    @if ($hotspot->status == 'pending')
                                        <button type="button" class="btn btn-sm btn-secondary resubmit" data-id="{{ $hotspot->id }}"    
                                        data-nama="{{ json_decode($hotspot->verify)->nama_lengkap ?? '' }}"
                                        data-tempat_lahir="{{ json_decode($hotspot->verify)->tempat_lahir ?? '' }}"
                                        data-tanggal_lahir="{{ json_decode($hotspot->verify)->tanggal_lahir ?? '' }}">
                                            <i class="bi bi-arrow-repeat"></i>
                                        </button>
                                        @else
                                        <button  type="button" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    @endif
                                    <button type="button" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
           </div>
            <div class="d-flex justify-content-between">
                <div class="py-2">
                    Total : ({{ $hotspots->total()}} / Hotspot Account)
                </div>
                <div class="d-flex align-items-center flex-row-reverse">
                    {{ $hotspots->onEachSide(0)->links('vendor.paginate') }}
                </div>
            </div>
        </div>
        <!-- end page main -->
    </div>


    <!-- Modal -->
    <div class="modal fade" id="verifyModal" tabindex="-1" aria-labelledby="verifyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="verifyModalLabel">Verify Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>Nama : <span id='nama_lengkap'></span></li>
                    <li>Tempat Lahir : <span id='tempat'></span></li>
                    <li>Tanggal Lahir : <span id='lahir'></span></li>
                </ul>
                <div>
                    <label for="form-label">Status</label>
                    <select name="form-status" class="form-select" id="status-select">
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Submit</button>
            </div>
        </div>
        </div>
    </div>
    @endsection

@push('scripts')
    <script>
         // Log out Active Modal
        $('.verify').click(function(e) {
            let id = $(this).data('id');
            let nama = $(this).data('nama') ?? 'Tidak ada';
            let lahir = $(this).data('lahir') ?? 'Tidak ada';
            let tempat_lahir = $(this).data('tempat_lahir') ?? 'Tidak ada';
            let status = $(this).data('status');
            // console.log(tempat_lahir)
            $('#nama_lengkap').html(nama);
            $('#lahir').html(lahir);
            $('#tempat').html(tempat_lahir);
            $('#status_select').val(status);
            $('#status_select').trigger('change');
            // Route delete
            let url = "{{ route('hotspot.logout', ':id') }}";
            route = url.replace(':id', id);
            // Action route for delete user
            $('#formLogOut').attr('action', route);
        });
    </script>
@endpush
