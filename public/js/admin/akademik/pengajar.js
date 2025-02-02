const pageState = {
  action: '',
  token: '',
  id: '',
  set setAction(d) {
    this.action = d;
  },
  set setToken(d) {
    this.token = d;
  },
  set setId(d) {
    this.id = d;
  }
};

pageState.setToken = $('input[name="_token"]').val();

// Load Table
$('#table_pengajar').dataTable({
  dom: 'Blfrtip',
  processing: true,
  serverSide: true,
  searching: true,
  responsive: {
    breakpoints: [
      { name: 'desktop', width: Infinity },
      { name: 'tablet', width: 1024 },
      { name: 'fablet', width: 768 },
      { name: 'phone', width: 480 }
    ]
  },
  autoWidth: true,
  ajax: {
    url: '/akademik/pengajar',
    type: 'POST',
    data: {
      _token: pageState.token
    },
  },
  columnDefs: [
    {
      targets: [0, 2],
      orderable: false,
    },
    {
      targets: 0,
      width: '10%'
    }
  ]
});

$(document).ready(function () {
  // Add & Update
  $('#btn_add_pengajar').on('click', function () {
    pageState.setAction = 'add';
    $('#form_add_pengajar').trigger('reset');
    $('#form_add_pengajar #btn_save').attr('disabled', false);
    $('#modal_add_pengajar .modal-title').html("Tambah Pengajar");
    $('#modal_add_pengajar').modal('show');
  });

  $('#table_pengajar').on('click', '.btn-edit', function () {
    pageState.setId = $(this).data('id');
    $('#modal_add_pengajar .modal-title').html("Edit Pengajar");
    $('#form_add_pengajar').trigger('reset');

    $.ajax({
      url: `/akademik/pengajar/${pageState.id}`,
      dataType: 'json',
      success: (res) => {
        pageState.setAction = 'edit';
        
        $('#form_add_pengajar #in_nama').val(res.nama);
        $('#form_add_pengajar #in_hp').val(res.no_hp);
        $(`input[name="in_gender"][value="${res.jns_kelamin}"]`).prop("checked", true);
        $('#form_add_pengajar #in_alamat').val(res.alamat);

        $('#modal_add_pengajar').modal('show');
      },
    });
  });

  $('#form_add_pengajar').on('submit', function (e) {
    e.preventDefault();
    let url = '', method = '';

    if (pageState.action == 'add') {
      url = '/akademik/pengajar/add';
      method = 'POST';
    } else if (pageState.action == 'edit') {
      url = `/akademik/pengajar/${pageState.id}`;
      method = 'PUT';
    }

    $.ajax({
      url,
      method,
      data: $(this).serialize(),
      beforeSend: () => {
        $("#form_add_pengajar #btn_save").attr("disabled", "disabled");
        $("#form_add_pengajar #btn_save").html("...tunggu..");
      },
      success: (res) => {
        $("#form_add_pengajar #btn_save").attr("disabled", false);
        $("#form_add_pengajar #btn_save").html("Simpan");

        $('#modal_add_pengajar').modal('hide');
        $('#table_pengajar').DataTable().ajax.reload(null, false);
      },
      error: (res) => {
        if (res.status == 422) {
          swal({
            title: 'Tak dapat diproses!!',
            text: 'Terdapat input yang salah atau mungkin data sudah ada',
            icon: 'warning',
          });
        }
        $("#form_add_pengajar #btn_save").attr("disabled", false);
        $("#form_add_pengajar #btn_save").html("Simpan");
      }
    });
  });

  $('#table_pengajar').on('click', '.btn-delete', function () {
    pageState.setId = $(this).data('id');

    swal({
      title: 'Yakin ingin dihapus?',
      text: 'Setelah dihapus, data tak akan pernah kembali lagi dan kemungkinan akan menyebabkan kerusakan pada data lain.',
      icon: 'warning',
      buttons: true,
      dangerMode: true,
    })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: `/akademik/pengajar/${pageState.id}`,
            method: "DELETE",
            data: {
              _token: pageState.token
            },
            success: (res) => {
              swal('Hayoloo kehapus!!!', {
                icon: 'success',
              });

              $('#table_pengajar').DataTable().ajax.reload(null, false);
            },
            error: (res) => {
              if (res.status == 500) {
                swal({
                  title: 'Tak dapat diproses!!',
                  text: 'Ada masalah di server',
                  icon: 'warning',
                });
              }
            }
          });
        } else {
          swal('Datamu aman :)');
        }
      });
  });
});