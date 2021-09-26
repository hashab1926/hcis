
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
            url: `${baseUrl}/unit_kerja/bagian/ajax/data_bagian`,
        });
    })

}
bagianSelect2();