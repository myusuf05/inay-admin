const _token = $('input[name="_token"]').val();
const id_kamar = location.pathname.split('/')[4];
// Load Table
$('#table_penghuni').dataTable({
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
    url: location,
    type: 'POST',
    data: {
      _token
    }
  },
  columnDefs: [
    {
      targets: [0, 3],
      orderable: false,
    },
    {
      targets: 0,
      width: '10%'
    },
    {
      targets: [2, 3],
      width: '20%'
    }
  ]
});

$(document).ready(function () {
  $('#table_penghuni').on('click', '.btn-delete', function () {
    const id_santri = $(this).data('id');

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
            url: location,
            method: "DELETE",
            data: {
              _token,
              id: id_santri
            },
            success: (res) => {
              swal('Hayoloo kehapus!!!', {
                icon: 'success',
              });

              $('#table_penghuni').DataTable().ajax.reload(null, false);
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

  // Add & Update
  $('#btn_add_penghuni').on('click', function () {
    $('#form_add_penghuni').trigger("reset");
    $("#form_add_penghuni #btn_save").attr("disabled", false);
    $('#modal_add_penghuni').modal('show');
  });

  $('#in_santri').select2({
    placeholder: "Pilih",
    dropdownParent: $('#modal_add_penghuni'),
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

  $('#form_add_penghuni').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
      url: `/pendataan/kamar/detail/add`,
      method: "post",
      data: $(this).serialize() + `&id_kamar=${id_kamar}`,
      success: (res) => {
        swal('Sukses', {
          icon: 'success',
        });

        $('#table_alumnis').DataTable().ajax.reload(null, false);
        $('#modal_add_penghuni').modal('hide');
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
})