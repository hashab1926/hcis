// rules
const rules = $('#jabatan-store').validate({
    rules: {
        nama_jabatan: {
            required: true,
            maxlength: 100,
        },
    },

    messages: {

        nama_jabatan: {
            required: 'jabatan harus diisi',
            maxlength: 'jabatan maksimal 100 karakter'
        },
    }
})

$('#jabatan-store').submit(function (evt) {
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