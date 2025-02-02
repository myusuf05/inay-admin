@extends('layouts.app')

@section('title', 'Mata Pelajaran')

@push('style')
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Rekap Presensi</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="/akademik/presensi/">Data Presensi</a></div>
        <div class="breadcrumb-item">Pendataan</div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between">
            <h4>Tabel Rekap Presensi</h4>
            <button class="btn btn-primary btn-sm" id="btn_add_presensi">
              <i class="fas fa-add"></i> <span> Tambah </span>
            </button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table-striped table table-bordered w-100 dt-responsive nowrap" id="table_presensi"
                cellspacing="0">
                <thead>
                  <tr>
                    <th> Tanggal </th>
                    <th> NIS </th>
                    <th> Santri </th>
                    <th> Kelas </th>
                    <th> Status </th>
                    <th> Waktu </th>
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
<div class="modal fade" tabindex="-1" role="dialog" id="modal_add_presensi">
  <div class="modal-dialog" role="document">
    <form method="POST" id="form_add_presensi">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Absensi</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="in_santri"> Santri </label>
            <select class="form-control select2" name="in_santri" id="in_santri" required>
            </select>
          </div>
          <div class="form-group">
            <label for="in_waktu"> Waktu Ngaji </label>
            <div class="selectgroup w-100">
              <label class="selectgroup-item">
                <input type="radio" name="in_waktu" value="pagi" class="selectgroup-input" checked>
                <span class="selectgroup-button">Pagi</span>
              </label>
              <label class="selectgroup-item">
                <input type="radio" name="in_waktu" value="sore" class="selectgroup-input">
                <span class="selectgroup-button">Maghrib</span>
              </label>
              <label class="selectgroup-item">
                <input type="radio" name="in_waktu" value="malam" class="selectgroup-input">
                <span class="selectgroup-button">Madrasah</span>
              </label>
            </div>
          </div>
          <div class="form-group">
            <label for="in_status"> Status Ijin </label>
            <div class="selectgroup w-100">
              <label class="selectgroup-item">
                <input type="radio" name="in_status" value="ijin" class="selectgroup-input" checked>
                <span class="selectgroup-button">Ijin</span>
              </label>
              <label class="selectgroup-item">
                <input type="radio" name="in_status" value="pulang" class="selectgroup-input">
                <span class="selectgroup-button">Pulang</span>
              </label>
              <label class="selectgroup-item">
                <input type="radio" name="in_status" value="sakit" class="selectgroup-input">
                <span class="selectgroup-button">Sakit</span>
              </label>
              <label class="selectgroup-item">
                <input type="radio" name="in_status" value="alpha" class="selectgroup-input">
                <span class="selectgroup-button">Bolos</span>
              </label>
            </div>
          </div>
          <div class="form-group">
            <label for="in_date"> Tanggal Ijin </label>
            <input type="date" class="form-control" id="in_date" name="in_date" required>
          </div>
          <div class="form-group">
            <label for="in_lama"> Berapa hari? </label>
            <input type="number" class="form-control" id="in_lama" name="in_lama" required>
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
<script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/admin/akademik/presensi.js') }}"></script>
@endpush