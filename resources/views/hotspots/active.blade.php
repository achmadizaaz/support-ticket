@extends('layouts.main')

@section('title', 'Active Hotspot')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="card p-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Active Hotspot</h4>
                <div class="page-title-right">
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
                <div class="d-flex align-items-center" style="width: 250px">
                    <div class="me-2 fw-bold">
                        Show :
                    </div>
                    <form action="{{ route('hotpost.session.perpage')}}" method="GET">
                        <select name="show" onchange="this.form.submit()" class="form-select form-select-sm" style="width: 100px">
                            <option value="10" @if (session('showPerPage') == 10)
                                selected
                            @endif>10</option>
                            <option value="25" @if (session('showPerPage') == 25)
                            selected
                            @endif>25</option>
                            <option value="50" @if (session('showPerPage') == 50)
                            selected
                            @endif>50</option>
                            <option value="100" @if (session('showPerPage') == 100)
                            selected
                            @endif>100</option>
                        </select>
                    </form>
                    <div class="ms-2 fw-bold">
                        Data
                    </div>
                </div>
               <div class="d-flex gap-1">
                    {{-- Input Pencarian --}}
                    <form action="{{ route('hotspot.active')}}" method="GET" class="d-flex gap-1">
                        <input type="text" name="search" class="form-control"  placeholder="Searching" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>

                    {{-- Button Reset --}}
                    <a href="{{ route('hotspot.active') }}" class="btn btn-info text-white" title="Reset">
                        <i class="bi bi-circle"></i>
                    </a>
               </div>
            </div>
           <div class="table-responsive">
            <table class="table">
                <thead>
                    <th>No</th>
                    <th>User</th>
                    <th>Address</th>
                    <th>Mac Address</th>
                    <th>Upload</th>
                    <th>Download</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach ($actives as $active)
                        <tr>
                            <td>{{ ($actives->currentPage() - 1) * $actives->perPage() + $loop->iteration }}</td>
                            {{-- {{ $loop->iteration }} --}}
                            <td>{{ $active['user'] }}</td>
                            <td>{{ $active['address'] }}</td>
                            <td>{{ $active['mac-address'] }}</td>
                            <td>{{ number_format($active['bytes-in']  / (1024 * 1024), 2) }} MB</td>
                            <td>{{ number_format($active['bytes-out']  / (1024 * 1024), 2) }} MB</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger log_out_active" data-bs-toggle="modal" data-bs-target="#logOutModal"  data-user="{{ $active['user'] }}" data-id="{{ $active['.id'] }}">
                                    Log out
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
            </table>
           </div>
           <div class="d-flex justify-content-between">
                <div class="py-2">
                    Total : ({{ $actives->total()}} / Hotspot Account)
                </div>
                <div class="d-flex align-items-center flex-row-reverse">
                    {{ $actives->onEachSide(0)->appends(['search' => $search])->links('vendor.paginate') }}
                </div>
            </div>
        </div>
        <!-- end page main -->
    </div>

    <div class="modal fade" id="logOutModal" tabindex="-1" aria-labelledby="logOutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="logOutModalLabel">Log out Hotspot</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" id="formLogOut" method="POST">
                    <div class="modal-body">
                        @csrf
                        @method('DELETE')
                        Apakah Anda ingin mengakhiri sesi pengguna ini,  <span class="fw-bold text-danger" id="modalName"></span>?
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

@endsection


@push('scripts')
    <script>
        // Log out Active Modal
        $('.log_out_active').click(function(e) {
            let user = $(this).data('user');
            let id = $(this).data('id');
            $('#modalName').html(user);
            // Route delete
            let url = "{{ route('hotspot.logout', ':id') }}";
            route = url.replace(':id', id);
            // Action route for delete user
            $('#formLogOut').attr('action', route);
        });
    </script>
@endpush