function pangkatSelect2() {

    const pangkat = $('select[data-name=id_pangkat]');
    let namaPangkat = '';
    let idPangkat = '';
    $.each(pangkat, function (index, select) {
        namaPangkat = $(select).attr('data-selected');
        idPangkat = $(select).attr('id');
        select2Request({
            element: `select[id=${idPangkat}]`,
            placeholder: namaPangkat ?? '- Pilih Pangkat -',
            url: `/pangkat/ajax/data_pangkat`,
        });
    })
}
pangkatSelect2();


function jabatanSelect2() {

    const jabatan = $('select[data-name=id_jabatan]');
    let namaJabatan = '';
    let idJabatan = '';
    $.each(jabatan, function (index, select) {
        namaJabatan = $(select).attr('data-selected');
        idJabatan = $(select).attr('id');

        select2Request({
            element: `select[id=${idJabatan}]`,
            placeholder: namaJabatan ?? '- Pilih Jabatan -',
            url: `/jabatan/ajax/data_jabatan`,
        });
    })
}
jabatanSelect2();


function divisiSelect2() {

    const divisi = $('select[data-name=id_divisi]');
    let namaDivisi = '';
    let idDivisi = '';
    $.each(divisi, function (index, select) {
        namaDivisi = $(select).attr('data-selected');
        idDivisi = $(select).attr('id');

        select2Request({
            element: `select[id=${idDivisi}]`,
            placeholder: namaDivisi ?? '- Pilih Divisi -',
            url: `/unit_kerja/divisi/ajax/data_divisi`,
        });
    })
}
divisiSelect2();

function kepalaSelect2() {

    const kepala = $('select[data-name=id_kepala]');
    let namaKepala = '';
    let idKepala = '';
    $.each(kepala, function (index, select) {
        namaKepala = $(select).attr('data-selected');
        idKepala = $(select).attr('id');

        select2Request({
            element: `select[id=${idKepala}]`,
            placeholder: namaKepala ?? '- Pilih Kepala -',
            url: `/unit_kerja/kepala/ajax/data_kepala`,
        });
    })
}
kepalaSelect2();


function bagianSelect2() {

    const bagian = $('select[data-name=id_bagian]');
    let namaBagian = '';
    let idBagian = '';
    $.each(bagian, function (index, select) {
        namaBagian = $(select).attr('data-selected');
        idBagian = $(select).attr('id');

        select2Request({
            element: `select[id=${idBagian}]`,
            placeholder: namaBagian ?? '- Pilih Bagian -',
            url: `/unit_kerja/bagian/ajax/data_bagian`,
        });
    })
}
bagianSelect2();