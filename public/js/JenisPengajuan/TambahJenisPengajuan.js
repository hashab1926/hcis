// rules
const rules = $('#jenispengajuan-store').validate({
    rules: {
        nama_jenis: {
            required: true,
            maxlength: 100,
        },
    },

    messages: {

        nama_jenis: {
            required: 'jenis pengajuan harus diisi',
            maxlength: 'jenis pengajuan maksimal 100 karakter'
        },
    }
})

$('#jenispengajuan-store').submit(function (evt) {
    evt.preventDefault();
    if (rules.valid() == false)
        return false;

    const data = new FormData(this);
    data.append(getCsrfName(), getCsrfHash());

    $.ajax({
        type: 'POST',
        data: data,
        url: './store',
        dataType: 'json',
        processData: false,
        contentType: false,
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

// upload 'kartik-upload'
$("#fileUpload").fileinput({
    showUpload: false,
    dropZoneEnabled: true,
    mainClass: "d-none",
    allowedFileExtensions: ["html"],
});
$('.file-preview').addClass(['no-border']);

