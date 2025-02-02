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
      <h1>Data Nilai</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="/akademik/nilai/">Data Nilai</a></div>
        <div class="breadcrumb-item">Pendataan</div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between">
            <h4>Tabel Mata Pelajaran</h4>
            <a class="btn btn-primary btn-sm" href="/akademik/nilai/tambah">
              <i class="fas fa-add"></i> <span> Tambah </span>
            </a>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table-striped table table-bordered w-100 dt-responsive nowrap" id="table_nilai"
                cellspacing="0">
                <thead>
                  <tr>
                    <th> Tanngal </th>
                    <th> NIS </th>
                    <th> Nama </th>
                    <th> Mapel </th>
                    <th> Tugas </th>
                    <th> Nilai </th>
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
<div class="modal fade" tabindex="-1" role="dialog" id="modal_add_nilai">
  <div class="modal-dialog" role="document">
    <form method="POST" id="form_add_nilai">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="in_santri"> Santri <b class="text-danger"> * </b></label>
            <div class="form-control" id="in_santri"></div>
          </div>
          <div class="form-group">
            <label for="in_mapel"> Mata Pelajaran <b class="text-danger"> * </b></label>
            <div class="form-control" id="in_mapel"></div>
          </div>
          <div class="form-group">
            <label for="in_tugas"> Penugasan <b class="text-danger"> * </b></label>
            <div class="form-control" id="in_tugas"></div>
            </select>
          </div>
          <div class="form-group">
            <label for="in_mapel"> Mata Pelajaran <b class="text-danger"> * </b></label>
            <div class="form-control" id="in_mapel"></div>
          </div>
          <div class="form-group">
            <label for="in_nilai"> Nilai <b class="text-danger"> * </b></label>
            <input type="number" class="form-control" min="0" id="in_nilai" name="in_nilai" required value="" required>
          </div>
          <div class="form-group">
            <label for="in_ket"> Keterangan </label>
            <textarea class="form-control" id="in_ket" name="in_ket">
            </textarea>
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
<script src="{{ asset('js/admin/akademik/nilai.js') }}"></script>
@endpush
