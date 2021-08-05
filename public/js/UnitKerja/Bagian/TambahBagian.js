// rules
const rules = $('#bagian-store').validate({
    rules: {

        id_divisi: {
            required: true,
            maxlength: 10,
        },
        kode_bagian: {
            maxlength: 20,
        },
        nama_bagian: {
            required: true,
            maxlength: 100,
        },
    },

    messages: {
        id_divisi: {
            required: 'unit divisi atau direktur harus diisi',
            maxlength: 'unit divisi atau direktur maksimal 100 karakter'
        },
        kode_bagian: {
            maxlength: 'kode bagian maksimal 100 karakter'
        },
        nama_bagian: {
            required: 'nama bagian harus diisi',
            maxlength: 'nama bagian maksimal 100 karakter'
        },

    }
});

$('#bagian-store').submit(function (evt) {
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
        url: `${baseUrl}/unit_kerja/bagian/store`,
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