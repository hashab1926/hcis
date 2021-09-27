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

function direktoratSelect2() {

    const kepala = $('select[data-name=id_direktorat]');
    let namaDirektorat = '';
    let idDirektorat = '';
    $.each(kepala, function (index, select) {
        namaDirektorat = $(select).attr('data-selected');
        idDirektorat = $(select).attr('id');

        select2Request({
            element: `select[id=${idDirektorat}]`,
            placeholder: namaDirektorat ?? '- Pilih Kepala -',
            url: `/unit_kerja/kepala/ajax/data_kepala`,
        });
    })

}
if ($('select[data-name=id_direktorat]').length > 0) {

    direktoratSelect2();
}


$('select[data-name=id_kepala]').change(function (evt) {
    const id = $(this).val();
    const index = $('select[data-name=id_kepala]').index(this);
    divisiSelect2(index, id);
})

$('select[data-name=id_divisi]').change(function (evt) {
    const id = $(this).val();
    const index = $('select[data-name=id_divisi]').index(this);
    bagianSelect2(index, id);
})

$('select[data-name=id_bagian]').change(function (evt) {
    const id = $(this).val();
    const index = $('select[data-name=id_bagian]').index(this);
    jabatanSelect2(index, id);
})

function divisiSelect2(indexElement, idKepala) {
    select2Request({
        element: `select[data-name=id_divisi]`,
        indexElement: indexElement,
        placeholder: '- Pilih Divisi -',
        url: `/unit_kerja/divisi/ajax/data_divisi/${idKepala}`,
    });

}



function bagianSelect2(indexElement, id) {

    select2Request({
        element: `select[data-name=id_bagian]`,
        indexElement: indexElement,
        placeholder: '- Pilih Bagian -',
        url: `/unit_kerja/bagian/ajax/data_bagian/${id}`,
    });
}

function jabatanSelect2(indexElement, id) {

    select2Request({
        element: `select[data-name=id_jabatan]`,
        indexElement: indexElement,
        placeholder: '- Pilih Jabatan -',
        url: `/jabatan/ajax/data_jabatan/${id}`,
    });
}
