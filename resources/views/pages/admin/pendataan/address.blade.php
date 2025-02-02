@extends('layouts.app')

@section('title', 'Setting')

@push('style')
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Prov, Kab & Kec</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#"> Alamat </a></div>
        <div class="breadcrumb-item">Setting Data</div>
        <div class="breadcrumb-item">Pendataan</div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between">
            <h4> Kecamatan </h4>
            <button class="btn btn-primary btn-sm" id="btn_add_kec">
              <i class="fas fa-add"></i>
            </button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table-striped table table-bordered w-100 dt-responsive nowrap" id="tabel_kec"
                cellspacing="0">
                <thead>
                  <tr>
                    <th data-priority="1">Kecamatan</th>
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
      <div class="col-12 col-md-6 col-lg-6">
        <div class="card">
          <div class="card-header d-flex justify-content-between">
            <h4> Kabupaten </h4>
            <button class="btn btn-primary btn-sm" id="btn_add_kab">
              <i class="fas fa-add"></i>
            </button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table-striped table table-bordered w-100 dt-responsive nowrap" id="table_kab"
                cellspacing="0">
                <thead>
                  <tr>
                    <th data-priority="1">Kabupaten</th>
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
      <div class="col-12 col-md-6 col-lg-6" style="min-height: 431px">
        <div class="card">
          <div class="card-header d-flex justify-content-between">
            <h4> Provinsi </h4>
            <button class="btn btn-primary btn-sm" id="btn_add_prov">
              <i class="fas fa-add"></i>
            </button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table-striped table table-bordered w-100 dt-responsive nowrap" id="table_prov"
                cellspacing="0">
                <thead>
                  <tr>
                    <th data-priority="1">Provinsi</th>
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
<div class="modal fade" tabindex="-1" role="dialog" id="modal_add_provinsi">
  <div class="modal-dialog" role="document">
    <form method="POST" id="form_add_kamar">
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
            <label for="in_setting"> Setting </label>
            <input type="text" class="form-control" id="in_setting" name="in_setting" placeholder="Umar 1" required>
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
<script src="{{ asset('js/admin/pendataan/data-address.js') }}"></script>
@endpush