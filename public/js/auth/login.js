$('form#form_login').on('submit', function (e) {
  e.preventDefault();
  $.ajax({
    url: "/auth/login",
    method: "POST",
    data: $(this).serialize(),
    success: function (data, status, f) {
      location.replace('/');
    },
    error: function (f) {
      if (f.status == '401') {
        swal({
          title: 'Gagal Login',
          text: f.responseText,
          icon: 'warning',
          dangerMode: true,
        });
      }

      if (f.status == '404') {
        swal({
          title: 'Gagal Login',
          text: 'User tak ditemukan',
          icon: 'warning',
          dangerMode: true,
        });
      }

      if (f.status == '422') {
        swal({
          title: 'Tidak dapat diproses',
          text: 'Email dan Password wajib diisi',
          icon: 'warning',
          dangerMode: true,
        });
      }
    }
  })
})