const hari = ['Ahad', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum`at', 'Sabtu'];
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
$('#table_jadwal').dataTable({
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
    url: '/akademik/jadwal',
    type: 'POST',
    data: {
      _token: pageState.token
    },
    
  },
  columnDefs: [
    {
      targets: [0, 7],
      orderable: false,
    },
    {
      targets: 0,
      width: '10%'
    },
    {
      targets: 1,
      render: function(d) {
        return hari[d];
      }
    },
    {
      targets: 4,
      render: function(d) {
        return `Ust. ${d}`;
      }
    }
  ]
});

$(document).ready(function () {
  // Add & Update
  $('#btn_add_jadwal').on('click', function () {
    pageState.setAction = 'add';
    $('#form_add_jadwal').trigger('reset');
    $('#form_add_jadwal select').val('0').trigger('change');
    $('#form_add_jadwal #btn_save').attr('disabled', false);
    $('#modal_add_jadwal').modal('show');
  });

  $('#table_jadwal').on('click', '.btn-edit', function () {
    pageState.setId = $(this).data('id');

    $.ajax({
      url: `/akademik/jadwal/${pageState.id}`,
      dataType: 'json',
      success: (res) => {
        pageState.setAction = 'edit';

        $('#form_add_jadwal #in_hari').val(res.hari).trigger('change');
        $('#form_add_jadwal #in_kelas').val(res.id_kelas).trigger('change');
        $('#form_add_jadwal #in_mapel').val(res.id_mapel).trigger('change');
        $('#form_add_jadwal #in_pengajar').val(res.id_pengajar).trigger('change');
        $('#form_add_jadwal #in_start').val(res.mulai);
        $('#form_add_jadwal #in_end').val(res.selesai);
        $('#modal_add_jadwal').modal('show');
      },
    });
  });

  $('#form_add_jadwal').on('submit', function (e) {
    e.preventDefault();
    let url = '', method = '';

    if (pageState.action == 'add') {
      url = '/akademik/jadwal/add';
      method = 'POST';
    } else if (pageState.action == 'edit') {
      url = `/akademik/jadwal/${pageState.id}`;
      method = 'PUT';
    }

    $.ajax({
      url,
      method,
      data: $(this).serialize(),
      beforeSend: () => {
        $("#form_add_jadwal #btn_save").attr("disabled", "disabled");
        $("#form_add_jadwal #btn_save").html("...tunggu..");
      },
      success: (res) => {
        $("#form_add_jadwal #btn_save").attr("disabled", false);
        $("#form_add_jadwal #btn_save").html("Simpan");

        $('#modal_add_jadwal').modal('hide');
        $('#table_jadwal').DataTable().ajax.reload(null, false);
      },
      error: (res) => {
        if (res.status == 422) {
          swal({
            title: 'Tak dapat diproses!!',
            text: 'Terdapat input yang salah atau mungkin data sudah ada',
            icon: 'warning',
          });
        }
        $("#form_add_jadwal #btn_save").attr("disabled", false);
        $("#form_add_jadwal #btn_save").html("Simpan");
      }
    });
  });

  $('#table_jadwal').on('click', '.btn-delete', function () {
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
            url: `/akademik/jadwal/${pageState.id}`,
            method: "DELETE",
            data: {
              _token: pageState.token
            },
            success: (res) => {
              swal('Hayoloo kehapus!!!', {
                icon: 'success',
              });

              $('#table_jadwal').DataTable().ajax.reload(null, false);
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

  getList();
});

function getList() {
  $('#in_hari').select2({
    placeholder: "Pilih",
    dropdownParent: $('#modal_add_jadwal'),
  });

  $.ajax({
    url: `/akademik/kelas/list`,
    method: "GET",
    dataType: 'json',
    success: function (res) {
      let html = '<option value="0" selected disabled> Pilih </option>';

      res.map(function (d) {
        html += `<option value="${d.id_kelas}"> ${d.kelas} </option>`;
      });

      $('#in_kelas').html(html);
      $('#in_kelas').select2({
        placeholder: "Pilih",
        dropdownParent: $('#modal_add_jadwal'),
      });
    },
  });

  $.ajax({
    url: `/akademik/mapel/list`,
    method: "GET",
    dataType: 'json',
    success: function (res) {
      let html = '<option value="0" selected disabled> Pilih </option>';

      res.map(function (d) {
        html += `<option value="${d.id_mapel}"> ${d.mapel} </option>`;
      });

      $('#in_mapel').html(html);
      $('#in_mapel').select2({
        placeholder: "Pilih",
        dropdownParent: $('#modal_add_jadwal'),
      });
    },
  });

  $.ajax({
    url: `/akademik/pengajar/list`,
    method: "GET",
    dataType: 'json',
    success: function (res) {
      let html = '<option value="0" selected disabled> Pilih </option>';

      res.map(function (d) {
        html += `<option value="${d.id_pengajar}"> (${d.nip}) ${d.nama} </option>`;
      });

      $('#in_pengajar').html(html);
      $('#in_pengajar').select2({
        placeholder: "Pilih",
        dropdownParent: $('#modal_add_jadwal'),
      });
    },
  });
}