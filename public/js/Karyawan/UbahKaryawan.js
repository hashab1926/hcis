
// kalo tombol ubah di klik
$('#toolbar-ubah').click(function (evt) {
    if (checkedBox.length <= 0) {
        warningMessage('Pesan', 'pilih karyawan terlebih dahulu');
        return false;
    }
    const menu = $('#menu').attr('data-menu');
    const data = checkedBox.join(',');
    if (menu != 'direktorat')
        document.location = `./karyawan/ubah/${encode(data)}`;
    else
        document.location = `./direktorat/ubah/${encode(data)}`;

})

// begitu tombol disimpan/ update
$('#karyawan-updatestore').submit(function (evt) {
    evt.preventDefault();
    let data = new FormData(this);

    data.append(getCsrfName(), getCsrfHash());
    data[data.length] = {
        name: getCsrfName(),
        value: getCsrfHash()
    };
    data = appendFiles(data, '.fileupload');
    $.ajax({
        type: 'POST',
        data: data,
        url: '/karyawan/ubah/store',
        processData: false,
        contentType: false,
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

function appendFiles(data, element) {
    const file = $(`${element}`);
    let id;
    for (let x = 0; x < file.length; x++) {
        id = file.eq(x).attr('data-id');
        data.append(`foto[${id}]`, file[x].files[0]);
    }

    return data;
}
$('.fileupload').change(function (evt) {
    const val = $(this).val();
    const index = $('.fileupload').index(this);
    $('.avatars').eq(index).html(`<span class="material-icons-outlined text-muted" style="font-size:150px">perm_identity</span>`);

    if (val == '') {
        $(this).val('');
        alert("file gagal di pilih");
        return false;

    }
    const file = evt.target.files[0];
    const allowedExtension = ['image/jpg', 'image/png', 'image/jpeg'];
    if (!allowedExtension.includes(file.type)) {
        alert("File harus berformat gambar");
        $(this).val('');
        return false;
    }

    const url = URL.createObjectURL(file);
    $('.avatars').eq(index).html(`<img src='${url}' width='170' height='150'>`);

})