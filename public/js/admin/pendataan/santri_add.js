$('#form_santri').on('submit', function (e) {
  e.preventDefault();

  $.ajax({
    url: `/pendataan/santri/add`,
    method: "POST",
    data: $(this).serialize(),
    success: function (res) {
      window.location.replace('/pendataan/santri/');
    },
    error: function (res) {
      // console.clear();
      swal({
        title: 'Gagal',
        text: "Gagal tambah data",
        icon: 'error',
        buttons: true,
        dangerMode: true,
      });
    },
  });
});