const id = location.pathname.split('/')[3];
const _token = $('input[name="_token"]').val();

$(document).ready(function () {
  $.ajax({
    url: `/pendataan/alumni/get/${id}`,
    method: "GET",
    dataType: 'json',
    success: (res) => {
      console.log(res);
      $(`input[name="alumni_gender"][value="${res.alumni_gender}"]`).attr('checked', 'checked');
      $('#ayah_job').val(res.ayah_pekerjaan).trigger('change');
      $('#ayah_study').val(res.ayah_pendidikan).trigger('change');
      $('#ayah_gaji').val(res.ayah_gaji).trigger('change');

      $('#ibu_job').val(res.ibu_pekerjaan).trigger('change');
      $('#ibu_study').val(res.ibu_pendidikan).trigger('change');
      $('#ibu_gaji').val(res.ibu_gaji).trigger('change');
    },
  });

  $('#form_alumni').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
      url: `/pendataan/alumni/${id}`,
      method: "PUT",
      data: $(this).serialize(),
      success: function (res) {
        swal({
          title: 'Sukses',
          text: 'Sukses mengubah data alumni',
          icon: 'success',
        })
          .then((willOk) => {
            if (willOk) {
              window.location.reload();
            }
          });
      },
      error: function (res) {
        swal({
          title: 'Gagal',
          icon: 'error',
          buttons: true,
          dangerMode: true,
        });
      },
    });
  });

  
})