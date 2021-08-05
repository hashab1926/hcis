// rules
const rules = $('#kepala-store').validate({
    rules: {

        kode_kepala: {
            required: true,
            maxlength: 20,
        },
        nama_kepala: {
            required: true,
            maxlength: 100,
        },
    },

    messages: {
        kode_kepala: {
            required: 'kode unit harus diisi',
            maxlength: 'kode unit maksimal 100 karakter'
        },
        nama_kepala: {
            required: 'nama unit harus diisi',
            maxlength: 'nama unit maksimal 100 karakter'
        },
    }
});

$('#kepala-store').submit(function (evt) {
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
        url: `${baseUrl}/unit_kerja/kepala/store`,
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