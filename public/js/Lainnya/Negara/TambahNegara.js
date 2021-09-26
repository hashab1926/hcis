// rules
const rules = $('#negara-store').validate({
    rules: {
        nama_negara: {
            required: true,
            maxlength: 100,
        },
    },

    messages: {

        nama_negara: {
            required: 'negara harus diisi',
            maxlength: 'negara maksimal 100 karakter'
        },

    }
});

$('#negara-store').submit(function (evt) {
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
        url: './store',
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