// rules
const rules = $('#divisi-store').validate({
    rules: {

        id_kepala: {
            required: true,
            maxlength: 10,
        },
        kode_divisi: {
            required: true,
            maxlength: 20,
        },
        nama_divisi: {
            required: true,
            maxlength: 100,
        },
        singkatan: { maxlength: 20 }
    },

    messages: {
        id_kepala: {
            required: 'unit kepala atau direktur harus diisi',
            maxlength: 'unit kepala atau direktur maksimal 100 karakter'
        },
        kode_divisi: {
            required: 'kode unit harus diisi',
            maxlength: 'kode unit maksimal 100 karakter'
        },
        nama_divisi: {
            required: 'nama unit harus diisi',
            maxlength: 'nama unit maksimal 100 karakter'
        },
        singkatan: {
            maxlength: 'singkatan atau alias maksimal 20 karakter'
        },
    }
});

$('#divisi-store').submit(function (evt) {
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
        url: `${baseUrl}/unit_kerja/divisi/store`,
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