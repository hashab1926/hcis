// kalo tombol ubah di klik
$('#toolbar-ubah').click(function (evt) {
    if (checkedBox.length <= 0) {
        warningMessage('Pesan', 'pilih unit terlebih dahulu');
        return false;
    }

    const data = checkedBox.join(',');
    document.location = `${baseUrl}/unit_kerja/bagian/ubah/${encode(data)}`;
})


// begitu tombol disimpan/ update
$('#bagian-updatestore').submit(function (evt) {
    evt.preventDefault();
    questionMessage("Pesan", "Apakah anda yakin, ingin mengubah data ini?")
        .then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                const data = $(this).serializeArray();
                data[data.length] = {
                    name: getCsrfName(),
                    value: getCsrfHash()
                };

                $.ajax({
                    type: 'POST',
                    data: data,
                    url: `${baseUrl}/unit_kerja/bagian/ubah/store`,
                    dataType: 'json',
                    beforeSend: function () {
                        enableLoading('ubah')
                    }
                }).done(function (response) {
                    resetCsrfToken(response.token)
                    disableLoading('ubah', buttonHtml);

                    if (response.status_code != 200) {
                        warningMessage('Pesan', response.message);
                        return false;
                    }

                    successMessage('Pesan', response.message);
                    setTimeout(function () {
                        document.location = response.action;
                    }, 2000)
                })
            } else if (result.isDenied) {
                Swal.close();
            }
        })
})