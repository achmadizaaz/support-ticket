@extends('layouts.main')

@section('title', Auth::user()->name)

@section('content')
    <div class="container-fluid">
        @if (Auth::user()->is_active || Auth::user()->hasRole('Super Administrator'))
            <div class="alert alert-success" role="alert">
                Your account is already active
            </div>
            @else
            <div class="alert alert-danger" role="alert">
                Your account is no longer active, please contact your <b>administrator</b> to reactivate your account.
            </div>
        @endif
    </div>
@endsection