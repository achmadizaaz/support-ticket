@extends('layouts.main')

@section('title', 'Support Ticket')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="card p-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Support Tickets</h4>
                <div class="page-title-right">
                    <a href="{{ route('ticket.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus me-2"></i> Create a ticket
                    </a>
                </div>
            </div>
        </div>
        <!-- end page title -->

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
                                <a href="{{ route('ticket.show', $ticket->no) }}">
                                    <div class="mb-2 fst-italic fw-semibold">#{{ $ticket->no }}</div>
                                    <div class="mb-2">{{ $ticket->subject }}</div>
                                </a>
                            </td>
                            <td class="align-middle">
                                @if ($ticket->status == 'open')
                                    <span class="btn btn-sm btn-outline-success">{{ $ticket->status }}</span>
                                @endif
                                @if ($ticket->status == 'answered')
                                    <span class="btn btn-sm btn-outline-secondary">{{ $ticket->status }}</span>
                                @endif
                                @if ($ticket->status == 'customer-reply')
                                    <span class="btn btn-sm btn-outline-info">{{ $ticket->status }}</span>
                                @endif
                                @if ($ticket->status == 'closed')
                                    <span class="btn btn-sm btn-outline-danger">{{ $ticket->status }}</span>
                                @endif
                            </td>
                            <td class="align-middle">{{ $ticket->user->username }}</td>
                            <td class="align-middle">{{ $ticket->updated_at }}</td>
                            <td class="align-middle text-center">
                                <a href="{{ route('ticket.show', $ticket->no) }}" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
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
    </div>
@endsection