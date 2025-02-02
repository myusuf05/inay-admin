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
                <h1>Data Jadwal</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/akademik/mapel/">Data Jadwal</a></div>
                    <div class="breadcrumb-item">Pendataan</div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Tabel Jadwal</h4>
                            <button class="btn btn-primary btn-sm" id="btn_add_jadwal">
                                <i class="fas fa-add"></i> <span> Tambah </span>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table table-bordered w-100 dt-responsive nowrap"
                                    id="table_jadwal" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th> No. </th>
                                            <th> Hari </th>
                                            <th> Kelas </th>
                                            <th> Mapel </th>
                                            <th> Pengajar </th>
                                            <th> Mulai </th>
                                            <th> Selesai </th>
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
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_add_jadwal">
        <div class="modal-dialog" role="document">
            <form method="POST" id="form_add_jadwal">
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
                            <label for="in_hari"> Pilih Hari <b class="text-danger"> * </b></label>
                            <select class="form-control select2" name="in_hari" id="in_hari" required>
                                <option value="0" disabled selected> Pilih </option>
                                <option value="1"> Senin </option>
                                <option value="2"> Selasa </option>
                                <option value="3"> Rabu </option>
                                <option value="4"> Kamis </option>
                                <option value="5"> Jum'at </option>
                                <option value="6"> Sabtu </option>
                                <option value="7"> Ahad </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="in_kelas"> Pilih Kelas <b class="text-danger"> * </b></label>
                            <select class="form-control select2" name="in_kelas" id="in_kelas" placeholder="Pilih"
                                required>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="in_mapel"> Pilih Mata Pelajaran <b class="text-danger"> * </b></label>
                            <select class="form-control select2" name="in_mapel" id="in_mapel" placeholder="Pilih"
                                required>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="in_pengajar"> Pilih Pengajar <b class="text-danger"> * </b></label>
                            <select class="form-control select2" name="in_pengajar" id="in_pengajar" placeholder="Pilih"
                                required>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="in_start"> Mulai dari <b class="text-danger"> * </b></label>
                            <input type="time" id="in_start" name="in_start">
                            {{-- <input type="text" name="in_start" id="in_start" class="form-control" required> --}}
                        </div>
                        <div class="form-group">
                            <label for="in_end"> Selasai pada <b class="text-danger"> * </b></label>
                            <input type="time" id="in_end" name="in_end">
                            {{-- <input type="text" name="in_end" id="in_end" class="form-control" required> --}}
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
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/admin/akademik/jadwal.js') }}"></script>
@endpush
