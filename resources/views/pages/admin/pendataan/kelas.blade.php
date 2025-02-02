@extends('layouts.app')

@section('title', 'Data Kelas')

@push('style')
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Kelas</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Data Kelas</a></div>
        <div class="breadcrumb-item">Akademik</div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between">
            <h4>Tabel Kelas</h4>
              <button class="btn btn-primary btn-sm" id="btn_add_kelas">
                <i class="fas fa-add"></i> <span> Tambah </span>
              </button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table-striped table table-bordered w-100 dt-responsive nowrap" id="table_grades"
                cellspacing="0">
                <thead>
                  <tr>
                    <th> No. </th>
                    <th data-priority="1">Kelas</th>
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
<div class="modal fade" tabindex="-1" role="dialog" id="modal_add_kelas">
  <div class="modal-dialog" role="document">
    <form method="POST" id="form_add_kelas">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Kelas</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="in_kelas"> Nama Kelas </label>
            <input type="text" class="form-control" id="in_kelas" name="in_kelas" required>
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
<script src="{{ asset('js/admin/pendataan/kelas.js') }}"></script>
@endpush