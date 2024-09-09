@extends('layouts.main')

@section('title', 'Support Ticket')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="card p-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-sm-0 font-size-18">Support Ticket List</h4>
                    <small class="fst-italic">List of ticket opend by customers</small>
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
                    <form action="{{ route('ticket.all')}}" method="GET" class="d-flex gap-1">
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
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th>No</th>
                        <th>Name</th>
                        <th>Ticket</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $ticket)
                            <tr>
                                <td class="align-middle">
                                    {{ ($tickets->currentPage() - 1) * $tickets->perPage() + $loop->iteration }}
                                </td>
                                <td class="align-middle">
                                    {{ $ticket->user->name }}
                                    <br>{{ $ticket->user->email }}
                                </td>
                                <td class="align-middle">
                                    <a href="{{ route('ticket.show', $ticket->slug) }}">
                                        <div class="mb-2 fst-italic fw-semibold">#{{ $ticket->no }}</div>
                                        <div class="mb-2">{{ $ticket->subject }}</div>
                                        <div class="badge bg-primary">{{ $ticket->category->name }}</div>
                                    </a>
                                </td>
                                <td class="align-middle">
                                    @if ($ticket->status == 'open')
                                        <span class="btn btn-sm btn-warning">{{ $ticket->status }}</span>
                                    @endif
                                    @if ($ticket->status == 'answered')
                                        <span class="btn btn-sm btn-info">{{ $ticket->status }}</span>
                                    @endif
                                    @if ($ticket->status == 'customer-reply')
                                        <span class="btn btn-sm btn-warning">{{ $ticket->status }}</span>
                                    @endif
                                    @if ($ticket->status == 'closed')
                                        <span class="btn btn-sm btn-danger">{{ $ticket->status }}</span>
                                    @endif
                                    @if ($ticket->status == 'completed')
                                        <span class="btn btn-sm btn-success">{{ $ticket->status }}</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div class="mb-2">
                                        Dibuat pada: <br>{{ $ticket->created_at->format('d-m-Y (h:i)') }}
                                    </div>
                                   @if ($ticket->updated_at > $ticket->created_at)
                                        <div class="mb-2">
                                            Diupdate pada: {{ $ticket->updated_at->diffForHumans() }}
                                        </div>
                                   @endif
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex gap-2 ">
                                        {{-- Show ticket --}}
                                        <a href="{{ route('ticket.show', $ticket->slug) }}" class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @can('delete-tickets')
                                            {{-- Delete Button --}}
                                            <button type="button" class="btn btn-sm btn-outline-danger delete_ticket" data-bs-toggle="modal" data-bs-target="#deleteModal" data-title="{{ $ticket->subject }}" data-no="{{ $ticket->no }}" data-slug="{{ $ticket->slug }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
                let subject = $(this).data('title');
                
                console.log(subject)
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