@extends('layouts.error')

@section('title', '500')

@push('style')
<!-- CSS Libraries -->
@endpush

@section('main')
<div class="page-error">
  <div class="page-inner">
    <h1>500</h1>
    <div class="page-description">
      Oppss,..Server error cuyy,..
    </div>
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