@extends('layouts.main')

@section('title', 'Sync Permission')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="card p-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Sync Permission</h4>
                <div class="page-title-right">
                    <div class="page-title-right">
                        <button type="button" class="btn btn-primary" disabled>
                            <i class="bi bi-arrow-repeat me-1"></i> Synchronize
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

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
        
        {{-- Change Role --}}
        @include('sync.select-role')
        {{-- END Change Role --}}

        <div class="alert alert-warning text-center fst-italic" role="alert">
            Tidak ada role yang terpilih, silakan pilih role dan klik button <b>Change Role</b>.
        </div>
        <!-- end page main -->
    </div>
@endsection

