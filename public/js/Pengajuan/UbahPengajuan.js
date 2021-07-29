// cek kalo ada yg inputannya 'data-mode-date=true'
const dateLength = $('.datelightpick-lama-perdin').length;
if (dateLength > 0) {
    for (let x = 0; x < dateLength; x++) {
        new Lightpick({
            field: document.getElementsByClassName('datelightpick-lama-perdin')[x],
            singleDate: false,
            numberOfMonths: 2,
            format: 'DD-MM-YYYY',
            onSelect: function (start, end) {
                const startDate = start.format('DD-MM-YYYY');
                const endDate = end.format('DD-MM-YYYY');
                $('#lampiran_lama_perdin_realisasi').val(`${startDate} - ${endDate}`);
                $('#text_lampiran_lama_perdin_realisasi').text(`${startDate} - ${endDate}`);
            }
        });
    }
}

function updateNilaiPengajuan() {
    let sumPengajuan = 0;
    $(document).find('.nilai_pengajuan').each(function (index, value) {
        sumPengajuan += parseInt($(value).val() == '' ? 0 : $(value).cleanVal());
    })

    return sumPengajuan;
}

function updateNilaiRealisasi() {
    let sumRealisasi = 0;
    $(document).find('.nilai_realisasi').each(function (index, value) {
        sumRealisasi += parseInt($(value).val() == '' ? 0 : $(value).cleanVal());
    })

    return sumRealisasi;
}

// kalo ada input uang
if ($('.currency-number').length > 0) {
    $(document).find('.currency-number').mask('000.000.000.000.000', { reverse: true });
}

// kalo ada buttom Tambah rincian pada 'Biaya perjalanan dinas'
if ($('#templating-tambah-rincian').length > 0) {
    $('#templating-tambah-rincian').click(function (evt) {
        evt.preventDefault();
        let no = $('#tbody-rincian-biaya tr').length + 1;
        $('#tbody-rincian-biaya').append(`
        <tr class='box-shadow'>
            <td class='padding-3 text-center'>${no}</td>
            <td class='padding-3'><input type='text' name='templating[jenis_fasilitas][]' class='form-control no-border' placeholder='Nama Rincian'></td>
            <td class='padding-3'><input type='text' dir="rtl" name='templating[nilai_pengajuan][]' class='form-control currency-number currency-number nilai_pengajuan no-border' placeholder='Nominal'></td>
            <td class='padding-3'><input type='text' dir="rtl" name='templating[nilai_realisasi][]' class='form-control currency-number currency-number nilai_realisasi no-border' placeholder='Nominal'></td>
            <td class='padding-3'>
                <button class='no-border no-background text-muted padding-x-1 hapus-rincian d-flex align-items-center justify-content-center padding-top-1 w-100'>
                    <span class='material-icons-outlined'>
                        highlight_off
                    </span>
                </button>
            </td>
        </tr>
        `);

        $(document).find('.currency-number').mask('000.000.000.000.000', { reverse: true });
    })
}

// kalo ada inputan nilai_pengajuan
if ($('.nilai_pengajuan').length > 0) {
    $(document).delegate('.nilai_pengajuan', 'change', function (evt) {
        const nilaiPengajuan = updateNilaiPengajuan();
        $('#total-nilai-pengajuan').html(currencyNumber(nilaiPengajuan));
    })

}


// kalo ada inputan realisasi
if ($('.nilai_realisasi').length > 0) {
    $(document).delegate('.nilai_realisasi', 'change', function (evt) {

        const nilaiRealisasi = updateNilaiRealisasi();
        $('#total-nilai-realisasi').html(currencyNumber(nilaiRealisasi));
    })

}

// kalo ada button hapus rincian
$(document).delegate('.hapus-rincian', 'click', function (evt) {
    $(this).parents('tr').remove();

    $('#total-nilai-pengajuan').text(currencyNumber(updateNilaiPengajuan()));
    $('#total-nilai-realisasi').text(currencyNumber(updateNilaiRealisasi()));

})
