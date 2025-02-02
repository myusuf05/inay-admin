$(document).ready(function () {
    const id = location.pathname.split("/")[3];

    // Set Radio and Select
    $.ajax({
        url: `/pendataan/santri/get/${id}`,
        method: "GET",
        dataType: "json",
        success: (res) => {
            $(`input[name="santri_gender"][value="${res.santri_gender}"]`).attr(
                "checked",
                "checked"
            );
            $('select[name="santri_status"]')
                .val(res.status_santri)
                .trigger("change");
            $('select[name="santri_kelas"]')
                .val(res.santri_kelas || 0)
                .trigger("change");
            $('select[name="santri_kamar"]')
                .val(res.santri_kamar || 0)
                .trigger("change");

            $('select[name="ayah_job"]')
                .val(res.ayah_pekerjaan)
                .trigger("change");
            $('select[name="ayah_study"]')
                .val(res.ayah_pendidikan)
                .trigger("change");
            $('select[name="ayah_gaji"]').val(res.ayah_gaji).trigger("change");

            $('select[name="ibu_job"]')
                .val(res.ibu_pekerjaan)
                .trigger("change");
            $('select[name="ibu_study"]')
                .val(res.ibu_pendidikan)
                .trigger("change");
            $('select[name="ibu_gaji"]').val(res.ibu_gaji).trigger("change");
        },
    });

    $("#form_santri").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: `/pendataan/santri/${id}`,
            method: "PUT",
            data: $(this).serialize(),
            success: function (res) {
                // window.location.replace('/pendataan/santri/');
                swal({
                    title: "Sukses",
                    text: "",
                    icon: "success",
                }).then((willOk) => {
                    if (willOk) {
                        window.location.href = "/pendataan/santri";
                    }
                });
            },
            error: function (res) {
                swal({
                    title: "Gagal",
                    text: "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                });
            },
        });
    });

    $("#set_alumni").on("click", function () {
        swal({
            title: "Kapan santri keluar?",
            content: {
                element: "input",
                attributes: {
                    type: "date",
                    required: true,
                },
            },
            closeOnClickOutside: false,
            icon: "warning",
            buttons: {
                cancel: "Tutup",
                confirm: {
                    text: "Set Alumni",
                    closeModal: false,
                },
            },
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: `/pendataan/santri/delete/${id}`,
                    method: "DELETE",
                    data: {
                        _token: $('input[name="_token"]').val(),
                        date: willDelete,
                    },
                    success: (res) => {
                        swal.stopLoading();
                        swal.close();
                        swal("Hayoloo kehapus!!!", {
                            icon: "success",
                        });

                        window.location.replace("/pendataan/alumni");
                    },
                    error: function (res) {
                        swal({
                            title: "Gagal set alumni!!",
                            icon: "error",
                            buttons: true,
                            dangerMode: true,
                        });
                    },
                });
            } else {
                swal("Tanggal diperlukan", {
                    icon: "error",
                });
            }
        });
    });
});
