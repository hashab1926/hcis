
// begitu tombol disimpan
$('#form-buatuser').submit(function (evt) {
    evt.preventDefault();
    questionMessage("Pesan", "Akun ini akan dibuat, apakah anda yakin ?")
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
                    url: `${baseUrl}/user/buat/store`,
                    dataType: 'json',
                    beforeSend: function () {
                        enableLoading('submit')
                    }
                }).done(function (response) {
                    resetCsrfToken(response.token)
                    disableLoading('submit', buttonHtml);

                    if (response.status_code != 201) {
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