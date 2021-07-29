function bagianSelect2() {
    const divisi = $('select[data-name=id_divisi]');
    let namaDivisi = '';
    let idDivisi = '';
    $.each(divisi, function (index, select) {
        namaDivisi = $(select).attr('data-selected');
        idDivisi = $(select).attr('id');

        select2Request({
            element: `select[id=${idDivisi}]`,
            placeholder: namaDivisi ?? '- Pilih Divisi -',
            url: `${baseUrl}/unit_kerja/divisi/ajax/data_divisi`,
        });
    })
}
bagianSelect2();