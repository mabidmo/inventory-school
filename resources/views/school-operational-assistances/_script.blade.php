<script>
    $(document).ready(function() {
        $(".show_modal").click(function() {
            let id = $(this).data("id")
            let token = $("input[name=_token]").val();

            $.ajax({
                type: "GET",
                url: "school-operational/json/" + id,
                data: {
                    id: id,
                    _token: token
                },
                success: function(data) {
                    $("#modalLabel").html(data.data.name)
                    $("#name").html(data.data.name)
                    $("#description").html(data.data.description)
                }
            })
        })

        $(".swal-edit-button").click(function() {
            let id = $(this).data("id");
            let token = $("input[name=_token]").val();

            // Injecting an id with relevant data on click for updating on #swal-update-button
            $("#swal-update-button").attr("data-id", id);

            $.ajax({
                url: "school-operational/json/" + id + "/edit",
                type: "GET",
                data: {
                    id: id,
                    _token: token
                },
                success: function(data) {
                    $("#name_edit").val(data.data.name)
                    $("#description_edit").val(data.data.description)
                },
                error: function(data) {
                    Swal.fire("Gagal!", "Tidak dapat melihat info kategori buku.",
                        "warning");
                }
            });
        });

        $("#swal-update-button").click(function(e) {
            e.preventDefault();
            // Get id injected by .swal-edit-button
            let id = $("#swal-update-button").attr("data-id");
            let token = $("input[name=_token]").val();

            let name = $("#name_edit").val();
            let description = $("#description_edit").val();

            $.ajax({
                url: "school-operational/json/" + id,
                type: "PUT",
                data: {
                    _token: token,
                    name: $("#name_edit").val(),
                    description: $("#description_edit").val()
                },
                success: function(data) {
                    Swal.fire({
                        title: "Berhasil",
                        text: "Data berhasil diubah.",
                        icon: "success",
                        timerProgressBar: true,
                        onBeforeOpen: () => {
                            Swal.showLoading();
                            timerInterval = setInterval(() => {
                                const content = Swal.getContent();
                                if (content) {
                                    const b = content.querySelector(
                                    "b");
                                    if (b) {
                                        b.textContent = Swal
                                            .getTimerLeft();
                                    }
                                }
                            }, 100);
                        },
                        showConfirmButton: false
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 800)
                },
                error: function(data) {
                    Swal.fire("Gagal!", "Tidak dapat mengubah data.", "warning");
                }
            });
        });

        $("form[name='school_operational_assistance_create']").submit(function(e) {
            e.preventDefault();
            let token = $("input[name=_token]").val();

            // Create FormData object to handle file upload
            let formData = new FormData($(this)[0]);

            $.ajax({
                type: "POST",
                url: "school-operational/json",
                data: formData,
                contentType: false, // No content type for FormData
                processData: false, // No processing for FormData
                headers: {
                    'X-CSRF-TOKEN': token
                },
                success: function(data) {
                    Swal.fire({
                        title: "Berhasil",
                        text: "Data berhasil ditambahkan.",
                        icon: "success",
                        timerProgressBar: true,
                        onBeforeOpen: () => {
                            // ... (existing Swal code) ...
                        },
                        showConfirmButton: false
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 500);
                },
                error: function(data) {
                    console.log('gagal');
                    console.log(data);
                }
            });
        });


        $(".swal-delete-button").click(function() {
            Swal.fire({
                title: "Hapus?",
                text: "Data tidak akan bisa dikembalikan.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya",
                cancelButtonText: "Batal"
            }).then(result => {
                if (result.value) {
                    let id = $(this).data("id");
                    let token = $("input[name=_token]").val();
                    $.ajax({
                        url: "school-operational/json/" + id,
                        type: "DELETE",
                        data: {
                            id: id,
                            _token: token
                        },
                        success: function(data) {
                            Swal.fire({
                                title: "Berhasil",
                                text: "Data berhasil dihapus.",
                                icon: "success",
                                timerProgressBar: true,
                                onBeforeOpen: () => {
                                    Swal.showLoading();
                                    timerInterval = setInterval(() => {
                                        const content = Swal
                                            .getContent();
                                        if (content) {
                                            const b = content
                                                .querySelector(
                                                    "b");
                                            if (b) {
                                                b.textContent =
                                                    Swal
                                                    .getTimerLeft();
                                            }
                                        }
                                    }, 100);
                                },
                                showConfirmButton: false
                            });

                            setTimeout(function() {
                                location.reload();
                            }, 500);
                        },
                        error: function(data) {
                            Swal.fire("Gagal!", "Data gagal dihapus.", "warning");
                        }
                    });
                }
            });
        });
    });
</script>
