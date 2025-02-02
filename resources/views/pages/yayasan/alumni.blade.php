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
              <div class="form-group">
                <label>Foto </label>
                <input type="file" name="santri_foto" id="santri_foto" class="form-control">
              </div>
              <div class="form-group">
                <label>Nama <b class="text-danger"> * </b> </label>
                <div class="form-control"> {{$data['santri']->nama}} </div>
              </div>
              <div class="form-group">
                <label class="form-label">Jenis Kelamin <b class="text-danger"> * </b></label>
                <div class="form-control">
                  {{$data['santri']->jns_kelamin === 'L' ? 'Laki-Laki' : 'Perempuan'}}
                </div>
              </div>
              <div class="form-group">
                <label>Tanggal Lahir <b class="text-danger"> * </b></label>
                <div class="form-control">
                  {{$data['santri']->tgl_lahir }}
                </div>
              </div>
              <div class="form-group">
                <label>Nomor Induk Keluarga <b class="text-danger"> * </b></label>
                <div class="form-control">
                  {{$data['santri']->nik }}
                </div>
              </div>
              <div class="form-group">
                <label>No. HP <b class="text-danger"> * </b></label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fas fa-phone"></i>
                    </div>
                  </div>
                  <div class="form-control">
                    {{$data['santri']->no_hp }}
                  </div>
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
                  <div class="form-control">
                    {{$data['santri']->email }}
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Tannggal Masuk <b class="text-danger"> * </b></label>
                <div class="form-control">
                  {{$data['santri']->tgl_masuk }}
                </div>
              </div>
              <div class="form-group">
                <label>Alamat <b class="text-danger"> * </b></label>
                <div class="form-control">
                  {{ $data['santri']->alamat }}
                </div>
              </div>
              <div class="form-group">
                <label>Tannggal Keluar <b class="text-danger"> * </b></label>
                <div class="form-control">
                  {{$data['santri']->tgl_keluar}}
                </div>
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
                <div class="form-control">
                  {{ $data['ayah']->nama ?? '' }}
                </div>
              </div>
              <div class="form-group">
                <label>Nomor Induk Keluarga <b class="text-danger"> * </b> </label>
                <div class="form-control">
                  {{$data['ayah']->nik ?? ''}}
                </div>
              </div>
              <div class="form-group">
                <label>No. HP <b class="text-danger"> * </b></label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fas fa-phone"></i>
                    </div>
                  </div>
                  <div class="form-control">
                    {{$data['ayah']->no_hp ?? ''}}
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Alamat <b class="text-danger"> * </b> </label>
                <div class="form-control" style="height: 100%">
                  {{$data['ayah']->alamat ?? ''}}
                </div>
              </div>
              <div class="form-group">
                <label>Penghasilan <b class="text-danger"> * </b></label>
                <div class="form-control" style="height: 100%">
                  {{$data['select']['ayah']['gaji']->gaji ?? '-'}}
                </div>
              </div>
              <div class="form-group">
                <label>Pekerjaan <b class="text-danger"> * </b></label>
                <div class="form-control" style="height: 100%">
                  {{$data['select']['ayah']['job']->pekerjaan ?? '-'}}
                </div>
              </div>
              <div class="form-group">
                <label>Pendidikan Terakhir <b class="text-danger"> * </b></label>
                <div class="form-control" style="height: 100%">
                  {{$data['select']['ayah']['study']->pendidikan ?? '-'}}
                </div>
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
                <label>Nama Ayah <b class="text-danger"> * </b> </label>
                <div class="form-control">
                  {{ $data['ibu']->nama ?? '' }}
                </div>
              </div>
              <div class="form-group">
                <label>Nomor Induk Keluarga <b class="text-danger"> * </b> </label>
                <div class="form-control">
                  {{$data['ibu']->nik ?? ''}}
                </div>
              </div>
              <div class="form-group">
                <label>No. HP <b class="text-danger"> * </b></label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fas fa-phone"></i>
                    </div>
                  </div>
                  <div class="form-control">
                    {{$data['ibu']->no_hp ?? ''}}
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Alamat <b class="text-danger"> * </b> </label>
                <div class="form-control" style="height: 100%">
                  {{$data['ibu']->alamat ?? ''}}
                </div>
              </div>
              <div class="form-group">
                <label>Penghasilan <b class="text-danger"> * </b></label>
                <div class="form-control" style="height: 100%">
                  {{$data['select']['ibu']['gaji']->gaji ?? '-'}}
                </div>
              </div>
              <div class="form-group">
                <label>Pekerjaan <b class="text-danger"> * </b></label>
                <div class="form-control" style="height: 100%">
                  {{$data['select']['ibu']['job']->pekerjaan ?? '-'}}
                </div>
              </div>
              <div class="form-group">
                <label>Pendidikan Terakhir <b class="text-danger"> * </b></label>
                <div class="form-control" style="height: 100%">
                  {{$data['select']['ibu']['study']->pendidikan ?? '-'}}
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>
</div>
@endsection

@push('scripts')
@endpush