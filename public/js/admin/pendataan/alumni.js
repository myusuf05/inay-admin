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

$('#table_alumnis').dataTable({
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
    url: '/pendataan/alumni/data',
    type: 'POST',
    data: {
      _token: pageState.token
    },
  },
  columnDefs: [
    {
      targets: 4,
      orderable: false,
    },
    {
      targets: 0,
      width: '10%'
    },
    {
      targets: [2, 3],
      render: function (e) {
        const date = new Date(e);

        return Intl.DateTimeFormat('id-GB', { dateStyle: 'medium' }).format(date);
      }
    }
  ]
});

$('#btn_add_santri').on('click', function (e) {
  e.preventDefault();

  $('#form_add_alumni').trigger("reset");
  $("#form_add_alumni #btn_save").attr("disabled", false);
  $('#modal_add_alumni').modal('show');
});

$('#form_add_alumni').on('submit', function (e) {
  e.preventDefault();

  $.ajax({
    url: `/pendataan/alumni/add`,
    method: "post",
    data: $(this).serialize(),
    success: (res) => {
      swal('Sukses', {
        icon: 'success',
      });

      $('#table_alumnis').DataTable().ajax.reload(null, false);
      $('#modal_add_alumni').modal('hide');
    },
    error: (res) => {
      let text = 'Server Error';

      if (res.status == 404 || res.status == 400) {
        text = res.responseText;
      }

      $("#form_add_kamar #btn_save").attr("disabled", false);
      $("#form_add_kamar #btn_save").html("Simpan");

      swal({
        title: 'Tak dapat diproses!!',
        text,
        icon: 'warning',
      });
    }
  });
});

$(document).ready(function () { 
  $('#santri').select2({
    placeholder: "Pilih",
    dropdownParent: $('#modal_add_alumni'),
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

  $('#table_alumnis').on('click', '.btn-delete', function () {
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
            url: `/pendataan/alumni/${pageState.id}`,
            method: "DELETE",
            data: {
              _token: pageState.token
            },
            success: (res) => {
              swal('Hayoloo kehapus!!!', {
                icon: 'success',
              });

              $('#table_alumnis').DataTable().ajax.reload(null, false);
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
