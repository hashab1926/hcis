const namaJabatan = $('select[data-name=id_jabatan]').attr('data-selected');
const namaPangkat = $('select[data-name=id_pangkat]').attr('data-selected');
const namaKepala = $('select[data-name=id_kepala]').attr('data-selected');
const namaDivisi = $('select[data-name=id_divisi]').attr('data-selected');
const namaBagian = $('select[data-name=id_bagian]').attr('data-selected');


select2Request({
    element: 'select[data-name=id_kepala]',
    placeholder: namaDivisi ?? '- Pilih Kepala -',
    url: `/unit_kerja/kepala/ajax/data_kepala`,
});

$('select[data-name=id_kepala]').change(function (evt) {
    const id = $(this).val();
    select2Request({
        element: 'select[data-name=id_divisi]',
        placeholder: namaDivisi ?? '- Pilih Divisi -',
        url: `/unit_kerja/divisi/ajax/data_divisi/${id}`,
    });
})

$('select[data-name=id_divisi]').change(function (evt) {
    const id = $(this).val();
    select2Request({
        element: 'select[data-name=id_bagian]',
        placeholder: namaDivisi ?? '- Pilih Bagian -',
        url: `/unit_kerja/bagian/ajax/data_bagian/${id}`,
    });

})

$('select[data-name=id_bagian]').change(function (evt) {
    const id = $(this).val();
    select2Request({
        element: 'select[data-name=id_jabatan]',
        placeholder: namaJabatan ?? '- Pilih Jabatan -',
        url: `/jabatan/ajax/data_jabatan/${id}`,
    });


})


select2Request({
    element: 'select[data-name=id_pangkat]',
    placeholder: namaPangkat ?? '- Pilih Pangkat -',
    url: `/pangkat/ajax/data_pangkat`,
});



