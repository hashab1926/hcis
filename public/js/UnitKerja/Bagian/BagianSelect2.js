const namaDivisi = $('select[data-name=id_divisi]').attr('data-selected');

select2Request({
    element: 'select[data-name=id_divisi]',
    placeholder: namaDivisi ?? '- Pilih Divisi -',
    url: `${baseUrl}/unit_kerja/divisi/ajax/data_divisi`,
});
