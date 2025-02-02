@extends('layouts.app')

@section('title', $data['santri']->nama)

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
      <h1>{{$data['santri']->nama}}</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Lihat</a></div>
        <div class="breadcrumb-item"><a href="/pendataan/alumni">Data Alumni</a></div>
        <div class="breadcrumb-item">Pendataan</div>
      </div>
    </div>
    <div class="section-body">
      <form class="row" action="POST" id="form_alumni">
        @csrf
        <div class="col-12">
          {{-- Data Santri --}}
          <div class="card">
            <div class="card-header">
              <h4>Data Santri</h4>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label>Foto </label>
                <input type="file" name="alumni_foto" id="alumni_foto" class="form-control">
              </div>
              <div class="form-group">
                <label>Nama <b class="text-danger"> * </b> </label>
                <input type="text" name="alumni_nama" id="alumni_nama" class="form-control" value="{{$data['santri']->nama}}">
              </div>
              <div class="form-group">
                <label class="form-label">Jenis Kelamin <b class="text-danger"> * </b></label>
                <div class="selectgroup w-100">
                  <label class="selectgroup-item">
                    <input type="radio" name="alumni_gender" value="L" class="selectgroup-input" checked="">
                    <span class="selectgroup-button">Laki-laki</span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="alumni_gender" value="P" class="selectgroup-input">
                    <span class="selectgroup-button">Perempuan</span>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label>Tanggal Lahir <b class="text-danger"> * </b></label>
                <input type="date" name="alumni_birth" class="form-control" value="{{$data['santri']->tgl_lahir}}">
              </div>
              <div class="form-group">
                <label>Nomor Induk Keluarga <b class="text-danger"> * </b></label>
                <input type="number" name="alumni_nik" class="form-control" value="{{$data['santri']->nik}}">
              </div>
              <div class="form-group">
                <label>No. HP <b class="text-danger"> * </b></label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fas fa-phone"></i>
                    </div>
                  </div>
                  <input type="number" name="alumni_hp" class="form-control" value="{{$data['santri']->no_hp}}">
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
                  <input type="alumni_email" name="alumni_email" class="form-control" value="{{$data['santri']->email}}">
                </div>
              </div>
              <div class="form-group">
                <label>Alamat <b class="text-danger"> * </b></label>
                <textarea name="alumni_alamat" id="alumni_alamat" class="form-control"> {{$data['santri']->alamat}} </textarea>
              </div>
              <div class="form-group">
                <label>Tannggal Masuk <b class="text-danger"> * </b></label>
                <input type="date" name="alumni_in" class="form-control" value="{{$data['santri']->tgl_masuk}}">
              </div>
              <div class="form-group">
                <label>Tannggal Keluar <b class="text-danger"> * </b></label>
                <input type="date" name="alumni_out" class="form-control" value="{{$data['santri']->tgl_keluar}}">
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
                <input type="text" name="ayah_nama" class="form-control" value="{{$data['ayah']->nama ?? ''}}">
              </div>
              <div class="form-group">
                <label>Nomor Induk Keluarga <b class="text-danger"> * </b> </label>
                <input type="number" name="ayah_nik" class="form-control" value="{{$data['ayah']->nik  ?? ''}}">
              </div>
              <div class="form-group">
                <label>No. HP <b class="text-danger"> * </b></label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fas fa-phone"></i>
                    </div>
                  </div>
                  <input type="number" name="ayah_hp" class="form-control" value="{{$data['ayah']->no_hp  ?? ''}}">
                </div>
              </div>
              <div class="form-group">
                <label>Alamat <b class="text-danger"> * </b> </label>
                <textarea name="ayah_alamat" id="" class="form-control">  {{$data['ayah']->alamat  ?? ''}} </textarea>
              </div>
              <div class="form-group">
                <label>Penghasilan <b class="text-danger"> * </b></label>
                <select class="form-control select2" name="ayah_gaji" id="ayah_gaji">
                  <option value="0" selected disabled> Pilih </option>
                </select>
              </div>
              <div class="form-group">
                <label>Pekerjaan <b class="text-danger"> * </b></label>
                <select class="form-control select2" name="ayah_job" id="ayah_job">
                  <option value="0" selected disabled> Pilih </option>
                </select>
              </div>
              <div class="form-group">
                <label>Pendidikan Terakhir <b class="text-danger"> * </b></label>
                <select class="form-control select2" name="ayah_study" id="ayah_study">
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
                <input type="text" class="form-control" name="ibu_nama" value="{{$data['ibu']->nama ?? ''}}">
              </div>
              <div class="form-group">
                <label>Nomor Induk Keluarga <b class="text-danger"> * </b></label>
                <input type="number" name="ibu_nik" class="form-control" value="{{$data['ibu']->nik ?? ''}}">
              </div>
              <div class="form-group">
                <label>No. HP <b class="text-danger"> * </b></label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fas fa-phone"></i>
                    </div>
                  </div>
                  <input type="number" name="ibu_hp" class="form-control" value="{{$data['ibu']->no_hp ?? ''}}">
                </div>
              </div>
              <div class="form-group">
                <label>Alamat <b class="text-danger"> * </b></label>
                <textarea name="ibu_alamat" class="form-control"> {{$data['ibu']->alamat ?? ''}} </textarea>
              </div>
              <div class="form-group">
                <label for="ibu_gaji">Penghasilan <b class="text-danger"> * </b></label>
                <select class="form-control select2" name="ibu_gaji" id="ibu_gaji">
                  <option value="0" selected disabled> Pilih </option>
                </select>
              </div>
              <div class="form-group">
                <label>Pekerjaan <b class="text-danger"> * </b></label>
                <select class="form-control select2" name="ibu_job" id="ibu_job">
                  <option value="0" selected disabled> Pilih </option>
                </select>
              </div>
              <div class="form-group">
                <label>Pendidikan Terakhir <b class="text-danger"> * </b></label>
                <select class="form-control select2" name="ibu_study" id="ibu_study">
                  <option value="0" selected disabled> Pilih </option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="card">
            <div class="card-body d-flex justify-content-end">
              {{-- <input type="button" class="btn btn-danger mx-2" id="set_alumni" value="Jadikan Alumni"> --}}
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
<script src="{{ asset('js/admin/pendataan/alumni_show.js') }}"></script>
@endpush