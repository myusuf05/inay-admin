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
$('#table_grades').dataTable({
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
    url: '/akademik/kelas/data',
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

// Delete
$('#table_grades').on('click', '.btn-delete', function () {
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
          url: `kelas/delete/${pageState.id}`,
          method: "DELETE",
          data: {
            _token: pageState.token
          },
          success: (res) => {
            swal('Hayoloo kehapus!!!', {
              icon: 'success',
            });

            $('#table_grades').DataTable().ajax.reload(null, false);
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
$('#btn_add_kelas').on('click', function () {
  pageState.setAction = 'add';
  $('#form_add_kelas').trigger("reset");
  $("#form_add_kelas #btn_save").attr("disabled", false);
  $('#modal_add_kelas').modal('show');
});

$('#table_grades').on('click', '.btn-edit', function () {
  pageState.setId = $(this).data('id');

  $.ajax({
    url: `kelas/${pageState.id}`,
    method: "POST",
    data: {
      _token: pageState.token
    },
    dataType: 'json',
    success: (res) => {
      pageState.setAction = 'edit';

      $('#form_add_kelas #in_kelas').val(res.kelas);
      $('#modal_add_kelas').modal('show');
    },
  });
});

$('#form_add_kelas').on('submit', function (e) {
  e.preventDefault();
  let url = '', method = '';

  if (pageState.action == 'add') {
    url = 'kelas/add';
    method = 'POST';
  } else if (pageState.action == 'edit') {
    url = `kelas/edit/${pageState.id}`;
    method = 'PUT';
  }

  $.ajax({
    url,
    method,
    data: $(this).serialize(),
    beforeSend: () => {
      $("#form_add_kelas #btn_save").attr("disabled", "disabled");
      $("#form_add_kelas #btn_save").html("...tunggu..");
    },
    success: (res) => {
      $("#form_add_kelas #btn_save").attr("disabled", false);
      $("#form_add_kelas #btn_save").html("Simpan");

      $('#modal_add_kelas').modal('hide');
      $('#table_grades').DataTable().ajax.reload(null, false);
    },
    error: (res) => {
      if (res.status == 422) {
        swal({
          title: 'Tak dapat diproses!!',
          text: 'Terdapat input yang salah atau mungkin data sudah ada',
          icon: 'warning',
        });
      }
      $("#form_add_kelas #btn_save").attr("disabled", false);
      $("#form_add_kelas #btn_save").html("Simpan");
    }
  });
});