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
$('#table_rooms').dataTable({
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
    url: '/pendataan/kamar/data',
    type: 'POST',
    data: {
      _token: pageState.token
    }
  },
  columnDefs: [
    {
      targets: [0, 4],
      orderable: false,
    },
    {
      targets: 0,
      width: '10%'
    },
    {
      targets: [2, 3, 4],
      width: '20%'
    },
    {
      targets: 2,
      render: function (a) {
        return a == 'L' ? 'Putra' : 'Putri'
      }
    }
  ]
});

$(document).ready(function () {
  // Delete
  $('#table_rooms').on('click', '.btn-delete', function () {
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
            url: `/pendataan/kamar/${pageState.id}`,
            method: "DELETE",
            data: {
              _token: pageState.token
            },
            success: (res) => {
              swal('Hayoloo kehapus!!!', {
                icon: 'success',
              });

              $('#table_rooms').DataTable().ajax.reload(null, false);
            },
            error: (res) => {
              if (res.status == 400) {
                swal({
                  title: 'Tak dapat diproses!!',
                  text: res.responseText,
                  icon: 'error',
                });
              }

              $("#form_add_kamar #btn_save").attr("disabled", false);
              $("#form_add_kamar #btn_save").html("Simpan");
            }
          });
        } else {
          swal('Datamu aman :)');
        }
      });
  });

  // Add & Update
  $('#btn_add_kamar').on('click', function () {
    pageState.setAction = 'add';
    $('#form_add_kamar').trigger("reset");
    $("#form_add_kamar #btn_save").attr("disabled", false);
    $('#modal_add_kamar').modal('show');
  });

  // Edit
  $('#table_rooms').on('click', '.btn-edit', function () {
    pageState.setId = $(this).data('id');

    $.ajax({
      url: `/pendataan/kamar/${pageState.id}`,
      method: "get",
      dataType: 'json',
      success: (res) => {
        pageState.setAction = 'edit';

        $(`#form_add_kamar input[name="in_area"][value="${res.area}"]`).prop('checked', true);
        $('#form_add_kamar #in_name').val(res.kamar);
        $('#form_add_kamar #in_maks').val(res.maks);
        $('#modal_add_kamar').modal('show');
      },
    });
  });

  $('#form_add_kamar').on('submit', function (e) {
    e.preventDefault();
    let url = '', method = '';

    if (pageState.action == 'add') {
      url = '/pendataan/kamar/add';
      method = 'POST';
    } else if (pageState.action == 'edit') {
      url = `/pendataan/kamar/${pageState.id}`;
      method = 'PUT';
    }

    $.ajax({
      url,
      method,
      data: $(this).serialize(),
      beforeSend: () => {
        $("#form_add_kamar #btn_save").attr("disabled", "disabled");
        $("#form_add_kamar #btn_save").html("...tunggu..");
      },
      success: (res) => {
        $("#form_add_kamar #btn_save").attr("disabled", false);
        $("#form_add_kamar #btn_save").html("Simpan");

        $('#modal_add_kamar').modal('hide');
        $('#table_rooms').DataTable().ajax.reload(null, false);
      },
      error: (res) => {
        if (res.status == 422) {
          swal({
            title: 'Tak dapat diproses!!',
            text: 'Terdapat input yang salah atau mungkin data sudah ada',
            icon: 'warning',
          });
        }

        $("#form_add_kamar #btn_save").attr("disabled", false);
        $("#form_add_kamar #btn_save").html("Simpan");
      }
    });
  });
});