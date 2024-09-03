@extends('layouts.main')

@section('title', 'Dashboard')
    
@section('content')
<div class="container-fluid">
    <!-- start page title -->
    {{-- <div class="card p-3">
        <div class="d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Dashboard</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div> --}}
    <!-- end page title -->

    <!-- start page main -->
    <div class="alert alert-info" role="alert">
        Selamat datang <b>{{ Auth::user()->name }}</b>, untuk membuat <i>support ticket</i> baru klik <a href="{{ route('ticket.create') }}">disini</a>.
    </div>
    <!-- end page main -->
    
</div> <!-- container-fluid -->
@endsection