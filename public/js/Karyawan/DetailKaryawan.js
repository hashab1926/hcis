
// kalo tombol detail di klik
$('#toolbar-detail').click(function (evt) {
    if (checkedBox.length <= 0) {
        warningMessage('Pesan', 'pilih karyawan terlebih dahulu');
        return false;
    }

    const data = checkedBox.join(',');
    document.location = `./karyawan/detail/${encode(data)}`;

})