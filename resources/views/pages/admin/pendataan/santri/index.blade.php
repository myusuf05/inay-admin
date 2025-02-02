@extends('layouts.app')

@section('title', 'Data Santri')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/responsive.bootstrap4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Santri</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Data Santri</a></div>
                    <div class="breadcrumb-item">Pendataan</div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Tabel Santri</h4>
                            <a href="/pendataan/santri/add" class="btn btn-primary btn-sm" id="btn_add_santri">
                                <i class="fas fa-add"></i> <span> Tambah </span>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                @csrf
                                <table class="table-striped table table-bordered w-100 dt-responsive nowrap"
                                    id="table_santris" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th> NIS </th>
                                            <th data-priority="1">Nama</th>
                                            <th class="text-center">Kamar</th>
                                            <th class="text-center">Kelas</th>
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

@push('scripts')
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/datatables/media/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('library/datatables/media/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('library/datatables/media/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/admin/pendataan/santri.js') }}"></script>
@endpush
