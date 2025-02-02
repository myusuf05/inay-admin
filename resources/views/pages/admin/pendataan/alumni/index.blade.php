@extends('layouts.app')

@section('title', 'Data Santri')

@push('style')
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Alumni</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Data Alumni</a></div>
        <div class="breadcrumb-item">Pendataan</div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between">
            <h4>Tabel Alumni</h4>
            <a href="#" class="btn btn-primary btn-sm" id="btn_add_santri">
              <i class="fas fa-add"></i> <span> Tambah </span>
            </a>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              @csrf
              <table class="table-striped table table-bordered w-100 dt-responsive nowrap" id="table_alumnis"
                cellspacing="0">
                <thead>
                  <tr>
                    <th> NIS </th>
                    <th data-priority="1">Nama</th>
                    <th class="text-center">Tanggal Masuk</th>
                    <th class="text-center">Tanggal Keluar</th>
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
<div class="modal fade" tabindex="-1" role="dialog" id="modal_add_alumni">
  <div class="modal-dialog" role="document">
    <form method="POST" id="form_add_alumni">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Alumni</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="santri"> Pilih Santri </label>
            <select name="santri" id="santri" class="form-control select2" required>
            </select>
          </div>
          <div class="form-group">
            <label for="tgl_keluar"> Tanggal keluar </label>
            <input type="date" name="tgl_keluar" id="tgl_keluar" class="form-control" required>
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
<script src="{{ asset('js/admin/pendataan/alumni.js') }}"></script>
@endpush