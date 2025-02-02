@extends('layouts.app')

@section('title', 'Jadwal')

@section('main')
{{-- if not login, dashboard full size --}}

<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1> Jadwal Ngaji </h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="/akademik/mapel/">Data Jadwal</a></div>
        <div class="breadcrumb-item">Pendataan</div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between">
            <h4> Kelas {{$data['kelas']}} </h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table-striped table table-bordered w-100 dt-responsive nowrap" id="table_jadwal"
                cellspacing="0">
                <thead>
                  <tr>
                    <th> Hari </th>
                    <th> Mata Pelajaran </th>
                    <th> Pengajar </th>
                    <th> Waktu </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data['jadwal'] as $jadwal)
                  <tr>
                    <td class="font-weight-bold"> {{$data['hari'][$jadwal->hari]}} </td>
                    <td> {{$jadwal->mapel}} </td>
                    <td> {{$jadwal->nama_pengajar}} </td>
                    <td>{{$jadwal->mulai}} d/d {{$jadwal->selesai}}</td>
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