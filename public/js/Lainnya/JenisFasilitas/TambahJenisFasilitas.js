// rules
const rules = $('#jenisfasilitas-store').validate({
    rules: {
        jenis_fasilitas: {
            required: true,
            maxlength: 100,
        },
        kode_fasilitas: {
            required: true,
            maxlength: 20,
        },
    },

    messages: {

        jenis_fasilitas: {
            required: 'jenis fasilitas harus diisi',
            maxlength: 'jenis fasilitas maksimal 100 karakter'
        },
        kode_fasilitas: {
            required: 'kode fasilitas harus diisi',
            maxlength: 'kode fasilitas maksimal 100 karakter'
        },
    }
});

$('#jenisfasilitas-store').submit(function (evt) {
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