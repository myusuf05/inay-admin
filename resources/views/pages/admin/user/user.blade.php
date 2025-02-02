@extends('layouts.app')

@section('title', 'Daftar Pengguna')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Daftar Pengguna</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Daftar Pengguna</a></div>
                    <div class="breadcrumb-item">Admin</div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Tabel Pengguna</h4>
                            <button class="btn btn-primary btn-sm" id="btn_add_user">
                                <i class="fas fa-add"></i> <span> Tambah </span>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table table-bordered w-100 dt-responsive nowrap"
                                    id="tabel_users" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th data-priority="1">Nama</th>
                                            <th>Email</th>
                                            <th>Akses</th>
                                            <th>Status</th>
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
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_add_user">
        <div class="modal-dialog" role="document">
            <form method="POST" id="form_add_user">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pengguna</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="in_name"> Nama </label>
                            <input type="text" class="form-control" id="in_name" name="in_name" required>
                        </div>
                        <div class="form-group">
                            <label for="in_name"> Email </label>
                            <select class="form-control" id="in_email" name="in_email" required>
                                <option value="email"> Pilih Email </option>
                                @foreach ($email as $emails)
                                    <option value="{{ $emails->email }}">{{ $emails->email }}</option>
                                @endforeach
                            </select>
                            {{-- <input type="email" class="form-control" id="in_email" name="in_email" required> --}}
                        </div>
                        <div class="form-group">
                            <label for="in_akses"> Akses </label>
                            <select class="form-control" id="in_akses" name="in_akses" required>
                                <option value="admin"> Admin </option>
                                <option value="santri"> Santri </option>
                                <option value="yayasan"> Yayasan </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="in_name"> Password </label>
                            <span style="font-size: .7em">(<a href="#" id="btn_generate_pass">Generate</a> | <a
                                    href="#" id="btn_clear_pass">Clear</a>) </span>
                            <input type="text" class="form-control" id="in_password" name="in_password" required>
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
    <script>
        $(document).ready(function() {
            $('#in_email').on('blur', function() {
                var email = $(this).val();
                if (email !== '') {
                    $.ajax({
                        url: '{{ route('admin.checkSantriEmail') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            email: email
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#in_name').val(response.nama);
                            } else {
                                alert(
                                    'Email tidak ditemukan dalam data santri. Silakan lanjutkan untuk menambahkan data baru.'
                                );
                                $('#in_name').val('');
                            }
                        },
                        error: function() {
                            alert('Terjadi kesalahan, silakan coba lagi.');
                        }
                    });
                }
            });

            // Additional functionalities for generating and clearing passwords
            $('#btn_generate_pass').on('click', function(e) {
                e.preventDefault();
                var randomPass = Math.random().toString(36).slice(-8);
                $('#in_password').val(randomPass);
            });

            $('#btn_clear_pass').on('click', function(e) {
                e.preventDefault();
                $('#in_password').val('');
            });
        });
    </script>
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/datatables/media/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('library/datatables/media/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('library/datatables/media/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/admin/users/user.js') }}"></script>
@endpush
