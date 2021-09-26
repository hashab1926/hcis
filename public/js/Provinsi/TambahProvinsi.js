// rules
const rules = $('#provinsi-store').validate({
    rules: {
        nama_provinsi: {
            required: true,
            maxlength: 100,
        },
    },

    messages: {

        nama_provinsi: {
            required: 'provinsi harus diisi',
            maxlength: 'provinsi maksimal 100 karakter'
        },
    }
});

$('#provinsi-store').submit(function (evt) {
    evt.preventDefault();
    if (rules.valid() == false)
        return false;

    const data = $(this).serializeArray();
    data[data.length] = {
        name: getCsrfName(),
        value: getCsrfHash()
    };

    $.ajax({
        type: 'POST',
        data: data,
        url: `${baseUrl}/provinsi/store`,
        dataType: 'json',
        beforeSend: function () {
            enableLoading('tambah')
        }
    }).done(function (response) {
        resetCsrfToken(response.token)
        disableLoading('tambah', buttonHtml);

        if (response.status_code != 201) {
            warningMessage('Pesan', response.message);
            return false;
        }

        successMessage('Pesan', response.message);
    })
}) 