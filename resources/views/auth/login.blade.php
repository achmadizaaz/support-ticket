@extends('layouts.guest')

@section('title', 'Login')

@push('head')
<style>
    html,
body {
  height: 100%;
}

.form-signin {
  max-width: 420px;
  padding: 1rem;
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
    $option = \App\Models\Option::whereIn('name', ['can-forget-password', 'sidebar-icon', 'can-register'])->get()->keyBy('name'); 
@endphp

@section('content')
<main class="form-signin w-100 m-auto card rounded-3">
      <div class="py-2 mb-md-3 text-center d-block auth-logo">
        <img src="{{ asset($option['sidebar-icon']->value ? 'storage/'. $option['sidebar-icon']->value : 'assets/images/laravel.png') }}" alt="" height="28"> <span class="logo-txt">{{ $option['site-title']->value ?? config('app.name', 'Laravel') }}</span>
      </div>
      <div class="auth-content">
        <div class="text-center">
            {{-- <h5 class="mb-0">Selamat Datang</h5> --}}
            <p class="text-muted mt-2">Silahkan login untuk melanjutkan ke {{ $option['site-title']->value ?? config('app.name', 'Laravel') }}.</p>
        </div>
        <form class="mt-4 pt-2"  method="POST" action="{{ route('login') }}">
          @csrf

          @if($errors->any())
            <div class="d-flex align-items-center alert alert-danger alert-dismissible fade show py-2" role="alert">
              <small>{{ implode('', $errors->all(':message')) }}</small>
              <button type="button" class="btn-close small" data-bs-dismiss="alert" aria-label="Close" style="padding: 12px;"></button>
            </div>
          @endif

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Masukan NIM/email/username yang terdaftar" name="login" value="{{ old('login') }}" autofocus>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
                <input type="password" class="form-control" placeholder="Masukan katasandi" name="password">
            </div>
            <div class="row mb-4">
                <div class="col">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember-check">
                        <label class="form-check-label" for="remember-check">
                            Remember me
                        </label>
                    </div>  
                </div>
                
            </div>
            <div class="mb-3">
                <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Sign In</button>
            </div>
        </form>

        <div class="d-flex justify-content-between py-2">
          
          @if ($option['can-register']->value == 'yes')
            <p class="text-muted mb-0">Don't have an account? <a href="{{ route('register') }}"
              class="text-primary fw-semibold fst-italic">Register </a> 
            </p>
          @endif

          @if ($option['can-forget-password']->value == 'yes')
            <a href="{{ route('password.request') }}" class="text-secondary fst-italic">Forgot password?</a>
          @endif

        </div>
    </div>
</main>

@endsection