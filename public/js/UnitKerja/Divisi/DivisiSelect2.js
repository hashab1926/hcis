const namaKepala = $('select[data-name=id_kepala]').attr('data-selected');

select2Request({
    element: 'select[data-name=id_kepala]',
    placeholder: namaKepala ?? '- Pilih Kepala -',
    url: `${baseUrl}/unit_kerja/kepala/ajax/data_kepala`,
});
