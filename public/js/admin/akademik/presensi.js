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
$('#table_presensi').dataTable({
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
    url: '/akademik/presensi',
    type: 'POST',
    data: {
      _token: pageState.token
    },
  },
  columnDefs: [
    {
      targets: [6],
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
  $('#btn_add_presensi').on('click', function () {
    pageState.setAction = 'add';
    $('#form_add_presensi').trigger('reset');
    $('#form_add_presensi #btn_save').attr('disabled', false);
    $('#modal_add_presensi').modal('show');
  });

  $('#form_add_presensi').on('submit', function (e) {
    e.preventDefault();
    let url = '', method = '';

    if (pageState.action == 'add') {
      url = '/akademik/presensi/add';
      method = 'POST';
    } else if (pageState.action == 'edit') {
      url = `presensi/${pageState.id}`;
      method = 'PUT';
    }

    $.ajax({
      url,
      method,
      data: $(this).serialize(),
      beforeSend: () => {
        $("#form_add_presensi #btn_save").attr("disabled", "disabled");
        $("#form_add_presensi #btn_save").html("...tunggu..");
      },
      success: (res) => {
        $("#form_add_presensi #btn_save").attr("disabled", false);
        $("#form_add_presensi #btn_save").html("Simpan");

        $('#modal_add_presensi').modal('hide');
        $('#table_presensi').DataTable().ajax.reload(null, false);
      },
      error: (res) => {
        if (res.status == 422) {
          swal({
            title: 'Tak dapat diproses!!',
            text: 'Terdapat input yang salah atau mungkin data sudah ada',
            icon: 'warning',
          });
        }
        $("#form_add_presensi #btn_save").attr("disabled", false);
        $("#form_add_presensi #btn_save").html("Simpan");
      }
    });
  });

  $('#table_presensi').on('click', '.btn-delete', function () {
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
            url: `/akademik/presensi/${pageState.id}`,
            method: "DELETE",
            data: {
              _token: pageState.token
            },
            success: (res) => {
              swal('Hayoloo kehapus!!!', {
                icon: 'success',
              });

              $('#table_presensi').DataTable().ajax.reload(null, false);
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

  get_list();
});

function get_list() {
  $('#in_santri').select2({
    placeholder: "Pilih Santri",
    dropdownParent: $('#modal_add_presensi'),
    ajax: {
      url: `/pendataan/santri/get`,
      method: "get",
      dataType: 'json',
      data: (res) => {
        return {
          term: res
        }
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (d) {
            return {
              text: `${d.id_santri} - ${d.nama}`,
              id: d.id_santri
            }
          })
        };
      }
    }
  });
}