@extends('layouts.app')

@section('title', 'Data Kamar')

@push('style')
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Kamar</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Data Kamar</a></div>
        <div class="breadcrumb-item">Pendataan</div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between">
            <h4>Tabel Kamar</h4>
            {{-- <button class="btn btn-primary btn-sm" data-toggle="modal" id="btn_add_kamar" data-target="#add_kamar">
              --}}
              <button class="btn btn-primary btn-sm" id="btn_add_kamar">
                <i class="fas fa-add"></i> <span> Tambah </span>
              </button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table-striped table table-bordered w-100 dt-responsive nowrap" id="table_rooms"
                cellspacing="0">
                <thead>
                  <tr>
                    <th> No. </th>
                    <th data-priority="1">Kamar</th>
                    <th>Area</th>
                    <th>Kapasitas</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
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

@section('modal')
<div class="modal fade" tabindex="-1" role="dialog" id="modal_add_kamar">
  <div class="modal-dialog" role="document">
    <form method="POST" id="form_add_kamar">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Kamar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="in_name"> Nama Ruang </label>
            <input type="text" class="form-control" id="in_name" name="in_name" required>
          </div>
          <div class="form-group">
            <label for="in_area" class="form-label"> Area </label>
            <div class="selectgroup w-100">
              <label class="selectgroup-item">
                <input type="radio" name="in_area" value="L" class="selectgroup-input" checked="" required>
                <span class="selectgroup-button">Putra</span>
              </label>
              <label class="selectgroup-item">
                <input type="radio" name="in_area" value="P" class="selectgroup-input" required>
                <span class="selectgroup-button">Putri</span>
              </label>
            </div>
          </div>
          <div class="form-group">
            <label for="in_maks"> Kapasitas Maksimal </label>
            <input type="number" class="form-control" id="in_maks" name="in_maks" required>
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="btn_save">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('library/datatables/media/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('library/datatables/media/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('library/datatables/media/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/admin/pendataan/kamar.js') }}"></script>
@endpush