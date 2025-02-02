@extends('layouts.auth')

@section('title', 'Login')

@push('style')
<link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">
@endpush

@section('auth-header')
<div class="login-brand">
  <img src="{{ asset('img/inay_logo.png') }}" alt="logo" width="100" class="shadow-light rounded-circle">
</div>
@endsection

@section('auth-main')
<div class="card card-info">
  <div class="card-header">
    <h4 class="text-info">Login</h4>
  </div>
  <div class="card-body">
    <form id="form_login" action="post" class="needs-validation" novalidate="">
      @csrf
      <div class="form-group">
        <label for="email">Email</label>
        <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
        <div class="invalid-feedback">
          Email wajib diisi
        </div>
      </div>
      <div class="form-group">
        <div class="d-block">
          <label for="password" class="control-label">Password</label>
        </div>
        <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
        <div class="invalid-feedback">
          Password wajib diisi
        </div>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-success btn-lg btn-block" tabindex="4">
          Login
        </button>
      </div>
    </form>
  </div>
</div>
<div class="text-muted mt-5 text-center">
  Tidak bisa login? <a href="mailto:ihwan.cfc@gmail.com">Kontak Admin</a>
</div>
@endsection

@push('scripts')
<script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/auth/login.js') }}"></script>
@endpush