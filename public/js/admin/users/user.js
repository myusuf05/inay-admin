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
$('#tabel_users').dataTable({
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
    url: '/user/data',
    type: 'POST',
    data: {
      _token: pageState.token
    },
  },
  columnDefs: [
    {
      targets: [2],
      class: 'text-capitalize'
    },
    {
      targets: [4],
      orderable: false,
    },
  ]
});

// Delete
$('#tabel_users').on('click', '.btn-delete', function () {
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
          url: `/user/delete/${pageState.id}`,
          method: "DELETE",
          data: {
            _token: pageState.token
          },
          success: (res) => {
            swal('Hayoloo kehapus!!!', {
              icon: 'success',
            });

            $('#tabel_users').DataTable().ajax.reload(null, false);
          },
          error: (res) => {
            if (res.status == 422) {
              swal({
                title: 'Tak dapat diproses!!',
                text: 'Terdapat input yang salah atau mungkin data sudah ada',
                icon: 'warning',
              });
            }
            $("#form_add_user #btn_save").attr("disabled", false);
            $("#form_add_user #btn_save").html("Simpan");
          }
        });
      } else {
        swal('Datamu aman :)');
      }
    });
});

// Add & Update
$('#btn_add_user').on('click', function () {
  pageState.setAction = 'add';
  $('#form_add_user').trigger("reset");
  $('#form_add_user #in_password').prop('readonly', false)
  $('#form_add_user #in_password').attr('placeholder', '');
  $('#form_add_user #in_password').val('');
  $("#form_add_user #btn_save").attr("disabled", false);
  $('#modal_add_user').modal('show');
});

$('#btn_generate_pass').on('click', function () {
  $('#in_password').val('');
  $('#in_password').val(generatePassword());
});

$('#btn_clear_pass').on('click', function () {
  $('#in_password').val('');
});

$('#tabel_users').on('click', '.btn-edit', function () {
  pageState.setId = $(this).data('id');

  $.ajax({
    url: `user/${pageState.id}`,
    method: "GET",
    data: {
      _token: pageState.token
    },
    dataType: 'json',
    success: (res) => {
      console.log(res);
      pageState.setAction = 'edit';

      $('#form_add_user #in_name').val(res.nama);
      $('#form_add_user #in_email').val(res.email);
      $('#form_add_user #in_password').val('');
      $('#form_add_user #in_password').attr('placeholder', 'Demi keamanan password disembunyikan');
      $('#form_add_user #in_password').prop('readonly', true);
      $('#modal_add_user').modal('show');
    },
  });
});

$('#form_add_user').on('submit', function (e) {
  e.preventDefault();
  let url = '', method = '';

  if (pageState.action == 'add') {
    url = 'user/add';
    method = 'POST';
  } else if (pageState.action == 'edit') {
    url = `user/edit/${pageState.id}`;
    method = 'PUT';
  }

  $.ajax({
    url,
    method,
    data: $(this).serialize(),
    beforeSend: () => {
      $("#form_add_user #btn_save").attr("disabled", "disabled");
      $("#form_add_user #btn_save").html("...tunggu..");
    },
    success: (res) => {
      $("#form_add_user #btn_save").attr("disabled", false);
      $("#form_add_user #btn_save").html("Simpan");

      $('#modal_add_user').modal('hide');
      $('#tabel_users').DataTable().ajax.reload(null, false);
    },
    error: (res) => {
      if (res.status == 422) {
        swal({
          title: 'Tak dapat diproses!!',
          text: 'Terdapat input yang salah atau mungkin data sudah ada',
          icon: 'warning',
        });
      }
      $("#form_add_user #btn_save").attr("disabled", false);
      $("#form_add_user #btn_save").html("Simpan");
    }
  });
});

$(`#tabel_users`).on('click', '.btn-active', function () {
  pageState.setId = $(this).data('id');

  $.ajax({
    url: `/user/active/${pageState.id}`,
    method: "PUT",
    data: {
      _token: pageState.token
    },
    success: (res) => {
      $(`#tabel_users`).DataTable().ajax.reload(null, false);
    }
  });
});

// $(document).ready(function () {
//   $('#in_santri').select2({
//     placeholder: "Pilih",
//     dropdownParent: $('#modal_add_user'),
//     ajax: {
//       url: `/pendataan/santri/get`,
//       method: "get",
//       dataType: 'json',
//       data: (res) => {
//         return {
//           term: res
//         }
//       },
//       processResults: function (data) {
//         return {
//           results: $.map(data, function (d) {
//             return {
//               text: `${d.id_santri} - ${d.nama}`,
//               id: d.id_santri
//             }
//           })
//         };
//       }
//     }
//   });
// });