@extends('layouts.main')

@section('title', 'Notif user Categories')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="card p-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Notif User Categories</h4>
                <div class="page-title-right">
                    <div class="page-title-right">
                        @can('create-notif-preferences')
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createNotifCategoryModal">
                                <i class="bi bi-plus me-2"></i> Create a notif
                            </button>

                            <!-- Modal Create NotifCategory -->
                            <div class="modal fade" id="createNotifCategoryModal" tabindex="-1" aria-labelledby="createNotifCategoryModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('notif.categories.store') }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="createNotifCategoryModalLabel">Create a role</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <select name="user" id="user" class="form-select" required>
                                                        <option value="">Silakan pilih pengguna</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}">{{ $user->username .'-'.$user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="form-label border-bottom mb-2 pb-2 fw-bold">Pilih Kategori</div>
                                                    @foreach ($categories as $category)
                                                        <div class="mb-2">
                                                            <input class="form-check-input me-2" type="checkbox" value="{{ $category->id }}" name="category[]" id="{{ $category->id.'-'.$category->name }}">
                                                            <label class="fw-normal" for="{{ $category->id.'-'.$category->name }}">
                                                                {{ $category->name }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">
                                                    Submit
                                                </button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Tutup
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="alert alert-primary" role="alert">
            Pengaturan notifikasi user yang memiliki role <b>admin</b>.
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
                    <form action="{{ route('roles.show.page')}}" method="GET">
                        <select name="show" onchange="this.form.submit()" class="form-select form-select-sm" style="width: 100px">
                            <option value="10" @if (session('showPageNotifCategorys') == 10)
                                selected
                            @endif>10</option>
                            <option value="25" @if (session('showPageNotifCategorys') == 25)
                            selected
                            @endif>25</option>
                            <option value="50" @if (session('showPageNotifCategorys') == 50)
                            selected
                            @endif>50</option>
                            <option value="100" @if (session('showPageNotifCategorys') == 100)
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
                    <form action="{{ route('roles')}}" method="GET" class="d-flex gap-1">
                        <input type="text" name="search" class="form-control"  placeholder="Searching" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>

                    {{-- Button Reset --}}
                    <a href="{{ route('roles') }}" class="btn btn-info text-white" title="Reset">
                        <i class="bi bi-circle"></i>
                    </a>
               </div>
            </div>
            <table class="table">
                <thead>
                    <th>No</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Notif Category</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach ($notifications as $userNotif)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $userNotif->username }}</td>
                            <td>{{ $userNotif->name }}</td>
                            <td>
                                @foreach ($userNotif->notif as $item)
                                    {{ $item->category->name }},
                                @endforeach
                            </td>
                            <td>
                                @can('delete-notif-preferences')
                                    <button type="button" class="btn btn-sm btn-danger confirm_delete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $userNotif->id }}" data-name="{{ $userNotif->name }}"  title="Delete role">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-between">
                <div class="py-2">
                    Total : ({{ $notifications->total()}} / Notification)
                </div>
                <div class="d-flex align-items-center flex-row-reverse">
                    {{ $notifications->onEachSide(0)->links('vendor.paginate') }}
                </div>
            </div>
        </div>
        <!-- end page main -->
    </div>


    @can('delete-notif-preferences')
        <!-- Modal Delete NotifCategory -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLabel">Delete Notif User Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="#" id="formDelete" method="POST">
                        <div class="modal-body">
                            @csrf
                            @method('DELETE')
                            <label for="confirm_delete" class="form-label">
                                Untuk menghapus pemberitahuan user, ketikan: confirm
                            </label>
                            <input type="text" class="form-control" name="confirm" id="confirm_delete" required placeholder="Ketikan: confirm">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Delete it.</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
    @push('scripts')
    <script>
        // Delete Modal
        $('.confirm_delete').click(function(e) {
            let name = $(this).data('name');
            let id = $(this).data('id');
            $('#modalName').html(name);
            // Route delete
            let url = "{{ route('notif.categories.delete', ':id') }}";
            route = url.replace(':id', id);
            // Action route for delete user
            $('#formDelete').attr('action', route);
        });
    </script>
@endpush

@endsection

