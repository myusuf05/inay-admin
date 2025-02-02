const pageState = {
  action: '',
  id: '',
  set setAction(d) {
    this.action = d;
  },
  set setId(d) {
    this.id = d;
  }
};

const _token = $('input[name="_token"]').val();

const data = {
  _token
};

const responsive = {
  breakpoints: [
    { name: 'desktop', width: Infinity },
    { name: 'tablet', width: 1024 },
    { name: 'fablet', width: 768 },
    { name: 'phone', width: 480 }
  ]
};

const columnDefs = [
  {
    targets: 2,
    orderable: false,
  }
];

const pageLength = 5;

const dom = 'Bfrtip';

const pagingType = 'simple';

const baseUrl = '/pendataan/setting/data/';

// Load Datatable
$('#table_pekerjaan').dataTable({
  dom,
  pageLength,
  processing: true,
  serverSide: true,
  searching: true,
  responsive,
  pagingType,
  autoWidth: true,
  ajax: {
    url: baseUrl + 'pekerjaan',
    type: 'POST',
    data
  },
  columnDefs
});

$('#table_pendidikan').dataTable({
  dom,
  pageLength,
  processing: true,
  serverSide: true,
  searching: true,
  responsive,
  pagingType,
  autoWidth: true,
  ajax: {
    url: baseUrl + 'pendidikan',
    type: 'POST',
    data
  },
  columnDefs
});

$('#table_gaji').dataTable({
  dom,
  pageLength,
  processing: true,
  serverSide: true,
  searching: true,
  responsive,
  pagingType,
  autoWidth: true,
  ajax: {
    url: baseUrl + 'gaji',
    type: 'POST',
    data
  },
  columnDefs
});

$('#table_status').dataTable({
  dom,
  pageLength,
  processing: true,
  serverSide: true,
  searching: true,
  responsive,
  pagingType,
  autoWidth: true,
  ajax: {
    url: baseUrl + 'status',
    type: 'POST',
    data
  },
  columnDefs
});

// Add Update Area
function showModalAdd(tableName, title) {
  $(`#btn_add_${tableName}`).click(function () {
    pageState.setAction = `add_${tableName}`;

    $('#form_add_setting').trigger("reset");
    $('#form_add_setting .modal-title').html(`Tambah ${title}`);
    $("#form_add_setting #btn_save").attr("disabled", false);
    $('label[for="in_setting"]').html(title);
    $('#modal_add_setting').modal('show');
  });
}

showModalAdd('pekerjaan', 'Pekerjaan');
showModalAdd('pendidikan', 'Pendidikan');
showModalAdd('gaji', 'Range Gaji');
showModalAdd('status', 'Status Santri');

function showModalUpdate(tableName, title) {
  $(`#table_${tableName}`).on('click', '.btn-edit', function () {
    pageState.setId = $(this).data('id');
    pageState.setAction = `edit_${tableName}`;

    $.ajax({
      url: baseUrl + `${tableName}/${pageState.id}`,
      method: "POST",
      data,
      dataType: 'json',
      success: (res) => {
        pageState.setAction = `edit_${tableName}`;

        $('#form_add_setting #in_setting').val(res.setting_value);
        $('#form_add_setting .modal-title').html(`Edit ${title}`);
        $('label[for="in_setting"]').html(title);
        $('#modal_add_setting').modal('show');
      },
    });
  });
}

showModalUpdate('pekerjaan', 'Pekerjaan');
showModalUpdate('pendidikan', 'Pendidikan');
showModalUpdate('gaji', 'Range Gaji');
showModalUpdate('status', 'Status Santri');

$('#form_add_setting').on('submit', function (e) {
  e.preventDefault();
  let pathUrl = '', method = '', tableName = '';
  
  switch (pageState.action) {
    case 'add_pekerjaan':
      pathUrl = 'pekerjaan/add';
      method = 'POST';
      tableName = 'pekerjaan';
      break;
    case 'add_pendidikan':
      pathUrl = 'pendidikan/add';
      method = 'POST';
      tableName = 'pendidikan';
      break;
    case 'add_gaji':
      pathUrl = 'gaji/add';
      method = 'POST';
      tableName = 'gaji';
      break;
    case 'add_status':
      pathUrl = 'status/add';
      method = 'POST';
      tableName = 'status';
      break;
    case 'edit_pekerjaan':
      pathUrl = `pekerjaan/edit/${pageState.id}`;
      method = 'PUT';
      tableName = 'pekerjaan';
      break;
    case 'edit_pendidikan':
      pathUrl = `pendidikan/edit/${pageState.id}`;
      method = 'PUT';
      tableName = 'pendidikan';
      break;
    case 'edit_gaji':
      pathUrl = `gaji/edit/${pageState.id}`;
      method = 'PUT';
      tableName = 'gaji';
      break;
    case 'edit_status':
      pathUrl = `status/edit/${pageState.id}`;
      method = 'PUT';
      tableName = 'status';
      break;
    default:
      pathUrl = '';
      method = '';
  }

  $.ajax({
    url: baseUrl + pathUrl,
    method,
    data: $(this).serialize(),
    beforeSend: () => {
      $("#form_add_setting #btn_save").attr("disabled", "disabled");
      $("#form_add_setting #btn_save").html("...tunggu..");
    },
    success: (res) => {
      $("#form_add_setting #btn_save").attr("disabled", false);
      $("#form_add_setting #btn_save").html("Simpan");

      $('#modal_add_setting').modal('hide');
      $(`#table_${tableName}`).DataTable().ajax.reload(null, false);
    },
    error: (res) => {
      if (res.status == 422) {
        swal({
          title: 'Tak dapat diproses!!',
          text: 'Terdapat input yang salah atau mungkin data sudah ada',
          icon: 'warning',
        });
      }
      $("#form_add_setting #btn_save").attr("disabled", false);
      $("#form_add_setting #btn_save").html("Simpan");
    }
  });
});

// Delete
function deleteData(tableName) {
  $(`#table_${tableName}`).on('click', '.btn-delete', function () {
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
            url: baseUrl + `${tableName}/delete/${pageState.id}`,
            method: "DELETE",
            data,
            success: (res) => {
              swal('Hayoloo kehapus!!!', {
                icon: 'success',
              });

              $(`#table_${tableName}`).DataTable().ajax.reload(null, false);
            },
            error: (res) => {
              if (res.status == 422) {
                swal({
                  title: 'Tak dapat diproses!!',
                  text: 'Terdapat input yang salah atau mungkin data sudah ada',
                  icon: 'warning',
                });
              }
              $("#form_add_setting #btn_save").attr("disabled", false);
              $("#form_add_setting #btn_save").html("Simpan");
            }
          });
        } else {
          swal('Datamu aman :)');
        }
      });
  });
}

deleteData('pekerjaan');
deleteData('pendidikan');
deleteData('gaji');
deleteData('status');

// Button Aktif
function activeData(tableName) {
  $(`#table_${tableName}`).on('click', '.btn-active', function () {
    pageState.setId = $(this).data('id');

    $.ajax({
      url: baseUrl + `${tableName}/active/${pageState.id}`,
      method: "PUT",
      data,
      success: (res) => {
        $(`#table_${tableName}`).DataTable().ajax.reload(null, false);
      }
    });
  });
}

activeData('pekerjaan');
activeData('pendidikan');
activeData('gaji');
activeData('status');
