@extends('layouts.app')

@section('title', 'Tambah Data Santri')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Input Data Santri</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Tambah</a></div>
                    <div class="breadcrumb-item"><a href="/pendataan/santri">Data Santri</a></div>
                    <div class="breadcrumb-item">Pendataan</div>
                </div>
            </div>
            <div class="section-body">
                <form class="row" action="POST" id="form_santri">
                    @csrf
                    <div class="col-12">
                        {{-- Data Santri --}}
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Santri</h4>
                            </div>
                            <div class="card-body">
                                {{-- <div class="form-group">
                <label>Foto </label>
                <input type="file" name="santri_foto" id="santri_foto" class="form-control">
              </div> --}}
                                <div class="form-group">
                                    <label>Nama <b class="text-danger"> * </b> </label>
                                    <input type="text" name="santri_nama" id="santri_nama" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Jenis Kelamin <b class="text-danger"> * </b></label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="santri_gender" value="L"
                                                class="selectgroup-input" checked="" required>
                                            <span class="selectgroup-button">Laki-laki</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="santri_gender" value="P"
                                                class="selectgroup-input" required>
                                            <span class="selectgroup-button">Perempuan</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir <b class="text-danger"> * </b></label>
                                    <input type="date" name="santri_birth" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Nomor Induk Keluarga <b class="text-danger"> * </b></label>
                                    <input type="number" name="santri_nik" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>No. HP <b class="text-danger"> * </b></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-phone"></i>
                                            </div>
                                        </div>
                                        <input type="number" name="santri_hp" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label> Email <b class="text-danger"> * </b></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                        </div>
                                        <input type="santri_email" name="santri_email" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Masuk <b class="text-danger"> * </b></label>
                                    <input type="date" name="santri_in" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Alamat <b class="text-danger"> * </b></label>
                                    <textarea name="santri_alamat" id="santri_alamat" class="form-control" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Status santri <b class="text-danger"> * </b></label>
                                    <select class="form-control select2" name="santri_status">
                                        <option value="0" selected disabled required> Pilih </option>
                                        <option value=""> A </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        {{-- Data Ayah --}}
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Ayah Kandung</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nama Ayah <b class="text-danger"> * </b> </label>
                                    <input type="text" name="ayah_nama" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Nomor Induk Keluarga <b class="text-danger"> * </b> </label>
                                    <input type="number" name="ayah_nik" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>No. HP <b class="text-danger"> * </b></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-phone"></i>
                                            </div>
                                        </div>
                                        <input type="number" name="ayah_hp" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Alamat <b class="text-danger"> * </b> </label>
                                    <textarea name="ayah_alamat" id="" class="form-control" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Penghasilan <b class="text-danger"> * </b></label>
                                    <select class="form-control select2" name="ayah_gaji" required>
                                        <option value="0" selected disabled> Pilih </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Pekerjaan <b class="text-danger"> * </b></label>
                                    <select class="form-control select2" name="ayah_job" required>
                                        <option value="0" selected disabled> Pilih </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Pendidikan Terakhir <b class="text-danger"> * </b></label>
                                    <select class="form-control select2" name="ayah_study" required>
                                        <option value="0" selected disabled> Pilih </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        {{-- Data Ibu --}}
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Ibu Kandung</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nama Ibu <b class="text-danger"> * </b></label>
                                    <input type="text" class="form-control" name="ibu_nama" required>
                                </div>
                                <div class="form-group">
                                    <label>Nomor Induk Keluarga <b class="text-danger"> * </b></label>
                                    <input type="number" name="ibu_nik" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>No. HP <b class="text-danger"> * </b></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-phone"></i>
                                            </div>
                                        </div>
                                        <input type="number" name="ibu_hp" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Alamat <b class="text-danger"> * </b></label>
                                    <textarea name="ibu_alamat" class="form-control" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Penghasilan <b class="text-danger"> * </b></label>
                                    <select class="form-control select2" name="ibu_gaji" required>
                                        <option value="0" selected disabled> Pilih </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Pekerjaan <b class="text-danger"> * </b></label>
                                    <select class="form-control select2" name="ibu_job" required>
                                        <option value="0" selected disabled> Pilih </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Pendidikan Terakhir <b class="text-danger"> * </b></label>
                                    <select class="form-control select2" name="ibu_study" required>
                                        <option value="0" selected disabled> Pilih </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body d-flex justify-content-end">
                                <input type="button" class="btn btn-danger mx-2" value="Jadikan Alumni">
                                <input type="submit" class="btn btn-info mx-2" value="Simpan">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/admin/pendataan/santri_function.js') }}"></script>
    <script src="{{ asset('js/admin/pendataan/santri_add.js') }}"></script>
@endpush
