@extends('layouts.main')

@section('title', 'Report Tickets')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="card p-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Report Tickets</h4>
            </div>
        </div>
        <!-- end page title -->
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
        <div class="card">
            <form action="{{ route('report.ticket.show') }}" method="POST">
                @csrf
                <div class="card-body row">
                    <div class="col-6 col-md-6 mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="col-6 col-md-6 mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                    <div class="col-6 col-md-6 mb-3">
                        <label for="status_ticket" class="form-label">Status</label>
                        <select name="status" class="form-select" id="status_ticket">
                            <option value="semua">All Statuses</option>
                            <option value="open">Open</option>
                            <option value="answered">Answered</option>
                            <option value="customer-reply">Customer Reply</option>
                            <option value="completed">Completed</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-6 mb-3">
                        <label for="roles" class="form-label">Roles</label>
                        <select name="role" class="form-select" id="roles">
                            <option value="semua">All Roles</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-file-text me-2"></i> Show Report
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <!-- end page main -->
    </div>
@endsection
