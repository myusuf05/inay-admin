@extends('layouts.app')

@section('title', 'Jadwal')

@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1> {{auth()->user()->nama}} </h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="/akademik/mapel/">Data Jadwal</a></div>
        <div class="breadcrumb-item">Pendataan</div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between">
            <h4> A. Nilai Akademik </h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table-striped table table-bordered w-100 dt-responsive nowrap" id="table_jadwal"
                cellspacing="0">
                <thead>
                  <tr>
                    <th> Mapel </th>
                    <th> Tugas </th>
                    <th> UTS </th>
                    <th> UAS </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data['nilai'] as $nilai)
                  <tr>
                    <td> {{ $nilai->mapel }} </td>
                    <td> {{ $nilai->nilai_tugas }} </td>
                    <td> {{ $nilai->nilai_uas ?? 0 }} </td>
                    <td> {{ $nilai->nilai_uts }} </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between">
            <h4> B. Kehadiran Mengaji </h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table-striped table table-bordered w-100 dt-responsive nowrap" id="table_jadwal"
                cellspacing="0">
                <thead>
                  <tr>
                    <th> Ijin </th>
                    <th> Alpha </th>
                    <th> Pulang </th>
                    <th> Sakit </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data['presensi'] as $presensi)
                  <tr>
                    <td> {{ $presensi->ijin ?? 0 }} </td>
                    <td> {{ $presensi->alpha ?? 0 }} </td>
                    <td> {{ $presensi->pulang ?? 0 }} </td>
                    <td> {{ $presensi->sakit ?? 0 }} </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@push('scripts')
{{-- <script src="{{ asset('js/santri/jadwal.js') }}"></script> --}}
@endpush