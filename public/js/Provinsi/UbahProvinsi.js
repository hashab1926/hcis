// kalo tombol ubah di klik
$('#toolbar-ubah').click(function (evt) {
    if (checkedBox.length <= 0) {
        warningMessage('Pesan', 'pilih provinsi terlebih dahulu');
        return false;
    }

    const data = checkedBox.join(',');
    document.location = `./provinsi/ubah/${encode(data)}`;
})


// begitu tombol disimpan/ update
$('#provinsi-updatestore').submit(function (evt) {
    evt.preventDefault();
    const data = $(this).serializeArray();
    data[data.length] = {
        name: getCsrfName(),
        value: getCsrfHash()
    };

    $.ajax({
        type: 'POST',
        data: data,
        url: '/provinsi/ubah/store',
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
})