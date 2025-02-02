@extends('layouts.app')

@section('title', 'Mata Pelajaran')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Pengajar</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/akademik/pengajar/">Data Mapel</a></div>
                    <div class="breadcrumb-item">Pendataan</div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Tabel Pengajar</h4>
                            <button class="btn btn-primary btn-sm" id="btn_add_pengajar">
                                <i class="fas fa-add"></i> <span> Tambah </span>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table table-bordered w-100 dt-responsive nowrap"
                                    id="table_pengajar" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th> ID </th>
                                            <th> Nama </th>
                                            <th> No. HP </th>
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
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_add_pengajar">
        <div class="modal-dialog" role="document">
            <form method="POST" id="form_add_pengajar">
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
                            <label for="in_nama"> Nama Pengajar <b class="text-danger"> * </b></label>
                            <input type="text" class="form-control" id="in_nama" name="in_nama" required
                                value="">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jenis Kelamin <b class="text-danger"> * </b></label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    <input type="radio" name="in_gender" value="L" class="selectgroup-input">
                                    <span class="selectgroup-button">Laki-laki</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="in_gender" value="P" class="selectgroup-input">
                                    <span class="selectgroup-button">Perempuan</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="in_hp"> No. HP <b class="text-danger"> * </b></label>
                            <input type="text" class="form-control" id="in_hp" name="in_hp" required
                                value="">
                        </div>
                        <div class="form-group">
                            <label for="in_alamat"> Alamat <b class="text-danger"> * </b></label>
                            <textarea name="in_alamat" id="in_alamat" class="form-control" required></textarea>
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
    <script src="{{ asset('js/admin/akademik/pengajar.js') }}"></script>
@endpush
