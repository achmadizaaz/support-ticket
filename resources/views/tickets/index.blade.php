@extends('layouts.main')

@section('title', 'Support Ticket')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="card p-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Support Tickets</h4>
                <div class="page-title-right">
                    @can('create-tickets')
                        <a href="{{ route('ticket.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus me-2"></i> Create a ticket
                        </a>
                    @endcan
                </div>
            </div>
        </div>
        <!-- end page title -->

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success:</strong> {{session('success') }}.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- start page main -->
        <div class="card p-3">
            <div class="d-flex justify-content-between mb-2">
                <div class="d-flex align-items-center" style="width: 250px">
                    <div class="me-2 fw-bold">
                        Show :
                    </div>
                    <form action="{{ route('users.show.page')}}" method="GET">
                        <select name="show" onchange="this.form.submit()" class="form-select form-select-sm" style="width: 100px">
                            <option value="10" @if (session('showPage') == 10)
                                selected
                            @endif>10</option>
                            <option value="25" @if (session('showPage') == 25)
                            selected
                            @endif>25</option>
                            <option value="50" @if (session('showPage') == 50)
                            selected
                            @endif>50</option>
                            <option value="100" @if (session('showPage') == 100)
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
                    <form action="{{ route('ticket')}}" method="GET" class="d-flex gap-1">
                        <input type="text" name="search" class="form-control"  placeholder="Searching" value="{{request('search') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>

                    {{-- Button Reset --}}
                    <a href="{{ route('ticket') }}" class="btn btn-info text-white" title="Reset">
                        <i class="bi bi-circle"></i>
                    </a>
                </div>
            </div>
            
            <table class="table">
                <thead>
                    <th>No</th>
                    <th>Category</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Created by</th>
                    <th>Last Update</th>
                    <th class="text-center">Action</th>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td class="align-middle">
                                {{ ($tickets->currentPage() - 1) * $tickets->perPage() + $loop->iteration }}
                            </td>
                            <td class="align-middle">{{ $ticket->category->name }}</td>
                            <td class="align-middle">
                                <a href="{{ route('ticket.show', $ticket->slug) }}">
                                    <div class="mb-2 fst-italic fw-semibold">#{{ $ticket->no }}</div>
                                    <div class="mb-2">{{ $ticket->subject }}</div>
                                </a>
                            </td>
                            <td class="align-middle">
                                @if ($ticket->status == 'opened')
                                    <span class="btn btn-sm btn-outline-warning">{{ $ticket->status }}</span>
                                @endif
                                @if ($ticket->status == 'answered')
                                    <span class="btn btn-sm btn-outline-info">{{ $ticket->status }}</span>
                                @endif
                                @if ($ticket->status == 'customer-reply')
                                    <span class="btn btn-sm btn-outline-warning">{{ $ticket->status }}</span>
                                @endif
                                @if ($ticket->status == 'closed')
                                    <span class="btn btn-sm btn-outline-danger">{{ $ticket->status }}</span>
                                @endif
                                @if ($ticket->status == 'completed')
                                    <span class="btn btn-sm btn-outline-success">{{ $ticket->status }}</span>
                                @endif
                            </td>
                            <td class="align-middle">{{ $ticket->user->username }}</td>
                            <td class="align-middle">{{ $ticket->updated_at }}</td>
                            <td class="align-middle text-center">
                                <a href="{{ route('ticket.show', $ticket->slug) }}" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @can('delete-tickets')
                                    {{-- Delete Button --}}
                                    <button type="button" class="btn btn-sm btn-outline-danger delete_ticket" data-bs-toggle="modal" data-bs-target="#deleteModal" data-subject={{ $ticket->subject }} data-no="{{ $ticket->no }}" data-slug="{{ $ticket->slug }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                @endcan
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-between">
                <div class="py-2">
                    Total : ({{ $tickets->total()}} / tickets)
                </div>
                <div class="d-flex align-items-center flex-row-reverse">
                    {{ $tickets->onEachSide(0)->appends(request()->input())->links('vendor.paginate') }}
                </div>
            </div>
        </div>
        <!-- end page main -->

        @can('delete-tickets')
            <!-- Modal Delete-->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="#" method="POST" id="deleteForm">
                            @csrf
                            @method('DELETE')
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="deleteModalLabel">Delete Ticket</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <ul>
                                    <li>No ticket: #<span class="ticket_no fw-semibold"></span></li>
                                    <li>Subject: <span class="ticket_subject fw-semibold"></span></li>
                                </ul>
                                Apakah anda yakin ingin menghapus ticket ini?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Delete it</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan
@endsection

@can('delete-ticket')
    @push('scripts')
        <script>
            $('.delete_ticket').click(function(e) {
                let no = $(this).data('no');
                let slug = $(this).data('slug');
                let subject = $(this).data('subject');
                
                // Insert Value Role
                $('.ticket_no').html(no);
                $('.ticket_subject').html(subject);

                // Route update
                let url = "{{ route('ticket.delete', ':slug') }}";
                route = url.replace(':slug', slug);
                // Action route for update
                $('#deleteForm').attr('action', route);
            });
        </script>
    @endpush
@endcan