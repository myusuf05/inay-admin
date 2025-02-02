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
$('#table_nilai').dataTable({
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
    url: '/akademik/nilai',
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
  $('#table_nilai').on('click', '.btn-edit', function () {
    pageState.setId = $(this).data('id');

    $.ajax({
      url: `/akademik/nilai/${pageState.id}`,
      dataType: 'json',
      success: (res) => {
        pageState.setAction = 'edit';
        $('#form_add_nilai #in_santri').html(`${res.id_santri} - ${res.nama}`);
        $('#form_add_nilai #in_mapel').html(res.mapel);
        $('#form_add_nilai #in_tugas').html(res.tugas);
        $('#form_add_nilai #in_nilai').val(res.nilai);
        $('#form_add_nilai #in_ket').val(res.tugas);
        $('#modal_add_nilai').modal('show');
      },
    });
  });

  $('#form_add_nilai').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
      url: `/akademik/nilai/${pageState.id}`,
      method: 'put',
      data: $(this).serialize(),
      beforeSend: () => {
        $("#form_add_nilai #btn_save").attr("disabled", "disabled");
        $("#form_add_nilai #btn_save").html("...tunggu..");
      },
      success: (res) => {
        $("#form_add_nilai #btn_save").attr("disabled", false);
        $("#form_add_nilai #btn_save").html("Simpan");

        $('#modal_add_nilai').modal('hide');
        $('#table_nilai').DataTable().ajax.reload(null, false);
      },
      error: (res) => {
        if (res.status == 422) {
          swal({
            title: 'Tak dapat diproses!!',
            text: 'Terdapat input yang salah atau mungkin data sudah ada',
            icon: 'warning',
          });
        }
        $("#form_add_nilai #btn_save").attr("disabled", false);
        $("#form_add_nilai #btn_save").html("Simpan");
      }
    });
  });

  $('#table_nilai').on('click', '.btn-delete', function () {
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
            url: `/akademik/nilai/${pageState.id}`,
            method: "DELETE",
            data: {
              _token: pageState.token
            },
            success: (res) => {
              swal('Hayoloo kehapus!!!', {
                icon: 'success',
              });

              $('#table_nilai').DataTable().ajax.reload(null, false);
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