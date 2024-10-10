@extends('layouts.guest')

@section('title', 'Register')

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
    $option = \App\Models\Option::whereIn('name', ['can-forget-password', 'sidebar-icon', 'can-register'])->get()->keyBy('name'); 
@endphp

@section('content')
<main class="form-signin w-100 m-auto card rounded-4">
    <form action="{{ route('register') }}" method="post">
        @csrf
        <div class="row">
            <div class="d-flex justify-content-between align-items-center p-2 mb-4 border-bottom">
                <div class="text-start">
                    <h5 class="fw-bold">Register Account</h5>
                    <span class="small text-secondary">Fill out the form carefully for registration</span>
                </div>
                <div class="text-center d-flex align-items-center auth-logo">
                  <img src="{{ asset($option['sidebar-icon']->value ? 'storage/'. $option['sidebar-icon']->value : 'assets/images/laravel.png') }}" alt="" height="28">
                  <span class="logo-txt">{{ $option['site-title']->value ?? config('app.name', 'Laravel') }}</span>
                </div>
            </div>
            @if (session('failed'))
            <div class="alert alert-danger" role="alert">
              <div class="d-flex justify-content-between border-bottom border-danger mb-2">
                  <h5 class="alert-heading">Errors:</h5>
                  <button type="button" class="btn-close small" data-bs-dismiss="alert" aria-label="Close" style="padding: 12px;"></button>
              </div>
              {{ session('failed') }}
          </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    <div class="d-flex justify-content-between border-bottom border-danger mb-2">
                        <h5 class="alert-heading">Errors:</h5>
                        <button type="button" class="btn-close small" data-bs-dismiss="alert" aria-label="Close" style="padding: 12px;"></button>
                    </div>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

                <div class="auth-content row">
                    <div class="col-12 col-sm-6 mb-3">
                      <label class="form-label">Name <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="name" placeholder="Nama lengkap kamu" name="name" value="{{ old('name') }}" autofocus required>
                  </div>
                  <div class="col-12 col-sm-6 mb-3">
                    <label class="form-label">NIM <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="username" placeholder="Nomor induk mahasiswa kamu" minlength="13" name="username" value="{{ old('username') }}"  required>
                  </div>
                  <div class="col-12 col-sm-6 mb-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" placeholder="Alamat email kamu" name="email" value="{{ old('email') }}"  required>
                  </div>
                  <div class="col-12 col-sm-6 mb-3">
                    <label class="form-label">Program Studi <span class="text-danger">*</span></label>
                    <select name="program_studi" id="unit" class="form-select">
                      <option value="">Pilih prodi sesuai, jurusan kamu</option>
                      @foreach ($units as $unit)
                          <option value="{{ $unit->slug }}">{{ $unit->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-12 col-sm-6 mb-3">
                    <label class="form-label">Phone <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <span class="input-group-text" id="basic-addon1">+62</span>
                      <input type="number" class="form-control" placeholder="Nomor ponsel kamu" name="phone" value="{{ old('phone') }}" oninput="validateNumberInput(this)">
                    </div>
                    
                    
                  </div>
                  <hr>
                  <div class="mb-3">
                    <label class="form-label">Password <span class="text-danger">*</span></label>
                      <input type="password" class="form-control" placeholder="Masukan katasandi" name="password" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Password Confirmation <span class="text-danger">*</span></label>
                      <input type="password" class="form-control" placeholder="Masukan ulang katasandi" name="password_confirmation" required>
                  </div>
                </div>

    
    
            
            <div class="d-flex justify-content-start justify-content-md-between align-items-center gap-1 mb-3 flex-wrap">
              <div class="text-start fst-italic">
                Dengan mendaftar, Anda menyetujui <a href="{{ route('terms-of-use') }}">Ketentuan Penggunaan</a> {{ config('app.name', 'Laravel') }}
              </div>
              <div>
                <a href="{{ route('login') }}" class="btn btn-secondary">Kembali</a>
                <button class="btn btn-primary waves-effect waves-light" type="submit">Register</button>
              </div>
            </div>
        </div>
    </form>
</main>

<script>
  function validateNumberInput(input) {
      // Hapus semua karakter yang bukan angka
      input.value = input.value.replace(/[^0-9]/g, '');
  }
</script>

@endsection