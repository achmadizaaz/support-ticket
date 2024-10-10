@extends('layouts.guest')

@section('title', 'Verify Email')

@push('head')
<style>
    html,
body {
  height: 100%;
}

.form-signin {
  max-width: 720px;
  padding: 1.2rem;
}

.form-signin .form-floating:focus-within {
  z-index: 2;
}

.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}

.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}

    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .b-example-divider {
      width: 100%;
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }

    .btn-bd-primary {
      --bd-violet-bg: #712cf9;
      --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

      --bs-btn-font-weight: 600;
      --bs-btn-color: var(--bs-white);
      --bs-btn-bg: var(--bd-violet-bg);
      --bs-btn-border-color: var(--bd-violet-bg);
      --bs-btn-hover-color: var(--bs-white);
      --bs-btn-hover-bg: #6528e0;
      --bs-btn-hover-border-color: #6528e0;
      --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
      --bs-btn-active-color: var(--bs-btn-hover-color);
      --bs-btn-active-bg: #5a23c8;
      --bs-btn-active-border-color: #5a23c8;
    }

    .bd-mode-toggle {
      z-index: 1500;
    }

    .bd-mode-toggle .dropdown-menu .active .bi {
      display: block !important;
    }
  </style>
@endpush

@php
    $option = \App\Models\Option::whereIn('name', ['can-forget-password', 'favicon', 'can-register'])->get()->keyBy('name'); 
@endphp


@section('content')
<main class="form-signin w-100 m-auto card rounded-4">
        <div class="row">
            <div class="d-flex justify-content-between align-items-center p-2 mb-4 border-bottom">
                <div class="text-start col-8">
                    <h5 class="fw-bold">Verify Email</h5>
                </div>
                <div class="text-center d-block auth-logo col-4">
                  <img src="{{ asset($option['favicon']->value ? 'storage/'. $option['favicon']->value : 'assets/images/laravel.png') }}" alt="" height="28">
                  <span class="logo-txt">{{ $option['site-title']->value ?? config('app.name', 'Laravel') }}</span>
                </div>
            </div>
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Email Address -->
            <div class="mb-3">
                Terima kasih telah mendaftar pada sistem Support Ticket! <br/><br/>
                Sebelum memulai, mengunakan sistem tiket dukungan (<i>Support Ticket</i>) Anda diwajibkan untuk melakukan verifikasi email dengan mengeklik tautan yang baru kami kirimkan melalui email.<br/><br/>
                Jika Anda tidak menerima email tersebut, Anda dapat melakukan permintaan ulang tautan verfikasi dengan mengeklik tombol <b>Resend Verification Email</b> dibawah!.
            </div>

            <div class="d-flex justify-content-between">
                {{-- Button Resend Verify Email --}}
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button class="btn btn-primary waves-effect waves-light" type="submit">
                        <i class="bi bi-link-45deg"></i> Resend Verification Email
                    </button>
                </form>
                {{-- Button Log out --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-secondary waves-effect waves-light" type="submit">
                        Log out
                    </button>
                </form>
            </div>

        </div>
</main>

@endsection
