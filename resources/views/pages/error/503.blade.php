@extends('layouts.error')

@section('title', '503')

@push('style')
<!-- CSS Libraries -->
@endpush

@section('main')
<div class="page-error">
  <div class="page-inner">
    <h1>503</h1>
    <div class="page-description">
      Opsss,.. Layanan tidak tersedia!!!
    <div class="mt-3">
      <a href="/">Ke dashboard</a>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->

<!-- Page Specific JS File -->
@endpush