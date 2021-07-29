$('#posisi').click(function (evt) {
    if ($('.issub').hasClass('d-none')) {
        $('.issub').removeClass('d-none');
        $('#status_caret').html('arrow_drop_down');
    } else {
        $('.issub').addClass('d-none');
        $('#status_caret').html('arrow_drop_up');

    }
})

$('#accButton').click(function (evt) {
    const id = $(this).attr('data-id');
    questionMessage("Pesan", "Pengajuan ini akan di ACC, apakah anda yakin ?")
        .then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: `${baseUrl}/pengajuan/storeacc`,
                    data: {
                        id: id,
                        [getCsrfName()]: getCsrfHash()
                    },
                    type: 'POST',
                    dataType: 'json',
                    beforeSend: function () {
                        enableLoading('btnacc')
                    },
                }).done(function (response) {
                    resetCsrfToken(response.token);
                    disableLoading('btnacc', `
                    <span class="material-icons-outlined">
                        check_circle
                    </span>
                    <div class='margin-left-2'>ACC</div>
                    `)

                    // kalo gagal dihapus
                    if (response.status_code != 200) {
                        warningMessage('Pesan', response.message);
                        return false;
                    }
                    // kalo berhasil dihapus
                    successMessage('Pesan', response.message);
                    document.location = response.action;
                });
            } else if (result.isDenied) {
                Swal.close();
            }
        })

})


$('#lock-lampiran').click(function (evt) {
    const id = $(this).attr('data-id');
    const nama = $(this).attr('data-nama');

    questionMessage("Pesan", `Untuk mengubah pengajuan ini diperlukan izin akses dari kepala divisi ${nama}`, 'question', 'Ajukan permintaan izin')
        .then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: `${baseUrl}/pengajuan/storeajuan`,
                    data: {
                        id: id,
                        [getCsrfName()]: getCsrfHash()
                    },
                    type: 'POST',
                    dataType: 'json',
                    beforeSend: function () {
                        enableLoading('btnajuan')
                    },
                }).done(function (response) {
                    resetCsrfToken(response.token);
                    disableLoading('btnajuan', `
                    <span class="material-icons-outlined">
                        topic
                    </span>
                    <div class='margin-left-2'>Ajukan Kelola pengajuan</div>
                    `)

                    // kalo gagal dihapus
                    if (response.status_code != 200) {
                        warningMessage('Pesan', response.message);
                        return false;
                    }
                    // kalo berhasil dihapus
                    successMessage('Pesan', response.message);
                    document.location = response.action;
                });
            } else if (result.isDenied) {
                Swal.close();
            }
        })

})




$('#btnAccAjuan').click(function (evt) {
    const id = $(this).attr('data-id');
    const nama = $(this).attr('data-nama');

    questionMessage("Pesan", `Anda akan Memberikan akses pengajuan ini kepada admin divisi, apakah anda yakin ? `)
        .then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: `${baseUrl}/pengajuan/storeaccajuan`,
                    data: {
                        id: id,
                        [getCsrfName()]: getCsrfHash()
                    },
                    type: 'POST',
                    dataType: 'json',
                    beforeSend: function () {
                        enableLoading('btnaccajuan')
                    },
                }).done(function (response) {
                    resetCsrfToken(response.token);
                    disableLoading('btnaccajuan', `
                    <span class="material-icons-outlined">
                        check_circle
                    </span>
                    <div class='margin-left-2'>Terima Ajuan</div>
                    `)

                    // kalo gagal dihapus
                    if (response.status_code != 200) {
                        warningMessage('Pesan', response.message);
                        return false;
                    }
                    // kalo berhasil dihapus
                    successMessage('Pesan', response.message);
                    document.location = response.action;
                });
            } else if (result.isDenied) {
                Swal.close();
            }
        })

})

$('#btnIsiLampiran').click(function (evt) {
    const id = $(this).attr('data-id');

    document.location = `${baseUrl}/pengajuan/detail/edit/${id}`;
})

