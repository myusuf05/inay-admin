$(document).ready(function () {
  $baseUrlData = '/pendataan/setting/data'
  // Get Pekerjaan
  $.ajax({
    url: `${$baseUrlData}/pekerjaan/all`,
    method: "GET",
    dataType: 'json',
    success: function (res) {
      let html = '<option value="0" selected disabled> Pilih </option>';

      res.map(function (d) {
        html += `<option value="${d.id_pekerjaan}"> ${d.pekerjaan} </option>`;
      });

      $('select[name="ayah_job"]').html(html);
      $('select[name="ibu_job"]').html(html);
      $('select[name="ibu_job"] select[name="ayah_job"]').select2();
    },
  });

  // Get Pendidikan
  $.ajax({
    url: `${$baseUrlData}/pendidikan/all`,
    method: "GET",
    dataType: 'json',
    success: function (res) {
      let html = '<option value="0" selected disabled> Pilih </option>';

      res.map(function (d) {
        html += `<option value="${d.id_pendidikan}"> ${d.pendidikan} </option>`;
      });

      $('select[name="ayah_study"]').html(html);
      $('select[name="ibu_study"]').html(html);
      $('select[name="ibu_study"] select[name="ayah_study"]').select2();
    },
  });

  // Get Gaji
  $.ajax({
    url: `${$baseUrlData}/gaji/all`,
    method: "GET",
    dataType: 'json',
    success: function (res) {
      let html = '<option value="0" selected disabled> Pilih </option>';

      res.map(function (d) {
        html += `<option value="${d.id_gaji}"> ${d.gaji} </option>`;
      });

      $('select[name="ibu_gaji"]').html(html);
      $('select[name="ayah_gaji"]').html(html);
      $('select[name="ibu_gaji"] select[name="ayah_gaji"]').select2();
    },
  });

  // Get Status Santri
  $.ajax({
    url: `${$baseUrlData}/status/all`,
    method: "GET",
    dataType: 'json',
    success: function (res) {
      let html = '<option value="0" selected disabled> Pilih </option>';

      res.map(function (d) {
        html += `<option value="${d.id_status}"> ${d.status} </option>`;
      });

      $('select[name="santri_status"]').html(html);
      $('select[name="santri_status"]').select2();
    },
  });

  // Kelas
  $.ajax({
    url: `/akademik/kelas/list`,
    method: "GET",
    dataType: 'json',
    success: function (res) {
      let html = '<option value="0" selected disabled> Pilih </option>';

      res.map(function (d) {
        html += `<option value="${d.id_kelas}"> ${d.kelas} </option>`;
      });

      $('select[name="santri_kelas"]').html(html);
      $('select[name="santri_kelas"]').select2();
    },
  });

  // Kamar
  $.ajax({
    url: `/pendataan/kamar/list`,
    method: "GET",
    dataType: 'json',
    success: function (res) {
      let html = '<option value="0" selected disabled> Pilih </option>';

      res.map(function (d) {
        html += `<option value="${d.id_kamar}" ${d.jumlah == d.maks ? 'disabled' : ''}> ${d.kamar} ${d.jumlah == d.maks ? '(Full)' : ''} </option>`;
      });

      $('select[name="santri_kamar"]').html(html);
      $('select[name="santri_kamar"]').select2();
    },
  });
});