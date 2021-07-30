
select2Request({
    element: 'select[data-name=id_cost_center]',
    placeholder: '- Pilih Cost Center -',
    url: `${baseUrl}/cost_center/ajax/data_costcenter`,
});

select2Request({
    element: 'select[data-name=id_unit_kerja_divisi]',
    placeholder: '- Pilih Divisi -',
    url: `${baseUrl}/unit_kerja/divisi/ajax/data_divisi`,
});


function select2RekapFbcj() {


    select2Request({
        element: 'select[data-name=id_bussiness_trans]',
        placeholder: '- Pilih Bussiness Trans -',
        url: `${baseUrl}/bussiness_trans/ajax/data_bussinesstrans`,
    });

    select2Request({
        element: 'select[data-name=id_wbs_element]',
        placeholder: '- Pilih Wbs Element -',
        url: `${baseUrl}/wbs_element/ajax/data_wbselement`,
    });


    select2Request({
        element: 'select[data-name=id_karyawan]',
        placeholder: '- Recepient -',
        url: `${baseUrl}/karyawan/ajax/data_karyawan`,
    });
}

select2RekapFbcj();