
// kalo tombol hapus di klik
$('#toolbar-hapus').click(function (evt) {
    questionMessage("Pesan", "Apakah anda yakin, ingin menghapus data yang anda pilih ?")
        .then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                const data = {
                    [getCsrfName()]: getCsrfHash(),
                    id_negara: checkedBox
                };

                $.ajax({
                    url: `${baseUrl}/negara/hapus`,
                    data: data,
                    type: 'POST',
                    dataType: 'json',
                }).done(function (response) {
                    resetCsrfToken(response.token);
                    // kalo gagal dihapus
                    if (response.status_code != 200) {
                        warningMessage('Pesan', response.message);
                        return false;
                    }

                    // kalo berhasil dihapus
                    successMessage('Pesan', response.message);
                    table.ajax.reload(null, false);
                    resetAll();

                })

            } else if (result.isDenied) {
                Swal.close();
            }
        })
})
