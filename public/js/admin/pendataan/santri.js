const pageState = {
    action: "",
    token: "",
    id: "",
    set setAction(d) {
        this.action = d;
    },
    set setToken(d) {
        this.token = d;
    },
    set setId(d) {
        this.id = d;
    },
};

pageState.setToken = $('input[name="_token"]').val();

// Load Table
$("#table_santris").dataTable({
    dom: "Blfrtip",
    processing: true,
    serverSide: true,
    searching: true,
    responsive: {
        breakpoints: [
            { name: "desktop", width: Infinity },
            { name: "tablet", width: 1024 },
            { name: "fablet", width: 768 },
            { name: "phone", width: 480 },
        ],
    },
    autoWidth: true,
    ajax: {
        url: "/pendataan/santri/data",
        type: "POST",
        data: {
            _token: pageState.token,
        },
    },
    columnDefs: [
        {
            targets: 4,
            orderable: false,
        },
        {
            targets: 0,
            width: "10%",
        },
    ],
});

// Delete
$("#table_santris").on("click", ".btn-delete", function () {
    pageState.setId = $(this).data("id");

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
                url: `/pendataan/santri/delete/${pageState.id}`,
                method: "DELETE",
                data: {
                    _token: pageState.token,
                    date: willDelete,
                },
                success: (res) => {
                    swal.stopLoading();
                    swal.close();
                    swal("Hayoloo kehapus!!!", {
                        icon: "success",
                    });

                    $("#table_santris").DataTable().ajax.reload(null, false);
                },
                error: function (res) {
                    swal({
                        title: "Gagal set alumni!!",
                        text: "",
                        icon: "error",
                        buttons: true,
                        dangerMode: true,
                    });
                },
            });
        }
    });
});
