select2Request({
    element: '#penandatangan',
    placeholder: '- Pilih Penandatangan -',
    url: `/karyawan/ajax/data_pejabat`,
});


select2Request({
    element: `select[data-name='id_wbs_element']`,
    placeholder: '- Pilih WBS Element -',
    url: `${baseUrl}/wbs_element/ajax/data_wbselement_kode`
})

select2Request({
    element: `select[data-name='id_cost_center']`,
    placeholder: '- Pilih Cost Center -',
    url: `${baseUrl}/cost_center/ajax/data_costcenter_kode`
})

select2Request({
    element: `select[data-name='id_bussiness_trans']`,
    placeholder: '- Pilih Bussiness Trans -',
    url: `${baseUrl}/bussiness_trans/ajax/data_bussinesstrans_kode`
})

select2Request({
    element: `select[data-name='id_provinsi']`,
    placeholder: '- Pilih Provinsi -',
    url: `${baseUrl}/provinsi/ajax/data_provinsi_nama`
})

select2Request({
    element: `select[data-name='negara']`,
    placeholder: '- Pilih Negara -',
    url: `${baseUrl}/negara/ajax/data_namanegara`
})

select2Request({
    element: `select[data-name='jenis_fasilitas']`,
    placeholder: '- Pilih Jenis Fasilitas -',
    url: `${baseUrl}/jenis_fasilitas/ajax/data_jenis_fasilitas_nama`
})



function ubahPengajuanSelect2() {

    const jenisFasilitas = $('select[data-name=ubah_jenis_fasilitas]');
    let namaJenis = '';
    let idJenis = '';
    $.each(jenisFasilitas, function (index, select) {
        namaJenis = $(select).attr('data-selected') ?? $(select).val() ?? '';
        idJenis = $(select).attr('id');

        select2Request({
            element: `select[id=${idJenis}]`,
            // placeholder: namaJenis ?? '- Pilih Jenis Fasilitas -',
            url: `${baseUrl}/jenis_fasilitas/ajax/data_jenis_fasilitas_nama`
        });

        if (namaJenis != '' || typeof namaJenis == 'undefined') {
            // $(`select[id=${idJenis}]`).val('data', { id: idJenis, text: namaJenis, });
            const option = new Option(namaJenis, namaJenis, true, true);
            $(`select[id=${idJenis}]`).append(option).trigger('change');
        }
    })

}

if ($('select[data-name=ubah_jenis_fasilitas]').length > 0) {
    ubahPengajuanSelect2();
}