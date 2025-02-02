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

$(document).ready(function () {
  $('#form_add_nilai').on('submit', function (e) {
    e.preventDefault();
    // console.log($(this).serialize());

    $.ajax({
      url: '/akademik/nilai/tambah',
      method: 'post',
      data: $(this).serialize(),
      beforeSend: () => {
        $("#form_add_nilai #btn_save").attr("disabled", "disabled");
        $("#form_add_nilai #btn_save").html("...tunggu..");
      },
      success: (res) => {
        // location.replace('/akademik/nilai/');
        $("#form_add_nilai #btn_save").attr("disabled", false);
        $("#form_add_nilai #btn_save").html("Simpan");
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

  get_list();
});

function get_list() {
  $('#in_santri').select2({
    placeholder: "Pilih Santri",
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