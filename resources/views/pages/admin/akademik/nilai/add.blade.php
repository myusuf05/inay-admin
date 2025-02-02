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
      <h1>Data Nilai Santri</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="/akademik/nilai/tambah">Tambah Nilai</a></div>
        <div class="breadcrumb-item active"><a href="/akademik/nilai/">Data Nilai</a></div>
        <div class="breadcrumb-item">Akademik</div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between">
            <h4> Input Nilai </h4>
          </div>
          <div class="card-body">
            <form method="POST" id="form_add_nilai">
              @csrf
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="in_santri"> Pilih Santri <b class="text-danger"> * </b></label>
                  <select class="form-control select2" name="in_santri" id="in_santri" required>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="in_tugas"> Penugasan <b class="text-danger"> * </b></label>
                  <select class="form-control select2" name="in_tugas" id="in_tugas" required>
                    <option value="0" disabled selected> Pilih </option>
                    <option value="tugas"> Tugas </option>
                    <option value="uts"> UTS </option>
                    <option value="uas"> UAS </option>
                  </select>
                </div>
              </div>
              <div class="col-12">
                <label for="tabel_nilai"> Input Nilai (<span class="text-danger"> Kosongkan jika tidak ingin mengisi salah satu nilai mapel. </span>)</label>
                <table class="table-striped table table-bordered w-100 dt-responsive nowrap" id="tabel_nilai"
                  cellspacing="0">
                  <thead>
                    <tr>
                      <th> No. </th>
                      <th class="text-center"> Mapel </th>
                      <th class="text-center"> Nilai <b class="text-danger"> * </b></th>
                      <th class="text-center"> Keterangan </th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($data['mapel'] as $i => $item)
                    <tr>
                      <td> {{ $i + 1 }} </td>
                      <td class="font-weight-bold"> {{ $item->mapel }} </td>
                      <td>
                        <div class="form-group mt-2 mb-2">
                          <input class="form-control" type="number" min="0" max="100" name="nilai[{{$i}}]" placeholder="Nilai">
                          <input class="form-control" type="hidden" name="id[{{$i}}]" value="{{ $item->id_mapel }}">
                        </div>
                      </td>
                      <td>
                        <div class="form-group mt-2 mb-2">
                          <textarea class="form-control" name="ket[{{$i}}]" placeholder="Keterangan"></textarea>
                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="btn_save">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@push('scripts')
<script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('library/datatables/media/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('library/datatables/media/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('library/datatables/media/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
<script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/admin/akademik/nilai_add.js') }}"></script>
@endpush