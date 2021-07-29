var input = new URLSearchParams(window.location.search);
$('#jenis_pengajuan').change(function (evt) {
    const value = $(this).val();
    document.location = `?jenis_pengajuan=${value}`;
})

loadPdf(`${baseUrl}/pengajuan/preview/${input.get('jenis_pengajuan')}`);

$('#templating-store').change(function (evt) {
    dataCustomPdf = new FormData(this);
    loadPdf(`${baseUrl}/pengajuan/preview/${input.get('jenis_pengajuan')}`);

})

// cek kalo ada yg inputannya 'data-mode-date=true'
const dateLength = $('.datelightpick-lama-perdin').length;
if (dateLength > 0) {
    for (let x = 0; x < dateLength; x++) {
        new Lightpick({
            field: document.getElementsByClassName('datelightpick-lama-perdin')[x],
            singleDate: false,
            numberOfMonths: 2,
            format: 'DD-MM-YYYY'
        });
    }
}

function updateNilaiRealisasi() {
    let sumRealisasi = 0;
    $(document).find('.nilai_realisasi').each(function (index, value) {
        sumRealisasi += parseInt($(value).cleanVal());
    })

    return sumRealisasi;
}

function updateNilaiPengajuan() {
    let sumPengajuan = 0;
    $(document).find('.nilai_pengajuan').each(function (index, value) {
        sumPengajuan += parseInt($(value).cleanVal());
    })

    return sumPengajuan;
}

function getFormData() {
    const dataTemplating = new FormData($('#templating-store')[0]);
    const dataTemplateRincian = new FormData($('#form-rincianbiaya')[0]);
    for (var pair of dataTemplateRincian.entries()) {
        dataTemplating.append(pair[0], pair[1]);
    }
    dataCustomPdf = dataTemplating;

    return dataTemplating;
}


var saclarIsiSurat = true;
$('#close-isi-surat').click(function (evt) {
    evt.preventDefault();
    $('.sidebar-right.isi-surat').css('right', '-350px');
    saclarIsiSurat = false;
})

$('#toolbar-isisurat').click(function (evt) {
    if (saclarIsiSurat == false) {
        $('.sidebar-right.isi-surat').css('right', '0')
        saclarIsiSurat = true;
    }
    else {
        $('.sidebar-right.isi-surat').css('right', '-350px');
        saclarIsiSurat = false;
    }


})


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
            <td class='padding-3'>${no}</td>
            <td class='padding-3'><input type='text' name='templating[jenis_fasilitas][]' class='form-control no-border' placeholder='Jenis fasilitas'></td>
            <td class='padding-3'><input type='text' dir="rtl" name='templating[nilai_pengajuan][]' class='form-control currency-number currency-number nilai_pengajuan no-border' placeholder='Nilai Pengajuan'></td>
            <td class='padding-3'><input type='text' dir="rtl" name='templating[nilai_realisasi][]' class='form-control currency-number currency-number nilai_realisasi no-border' placeholder='Nilai Realisasi'></td>
            <td class='padding-3'>
                <button class='no-border no-background text-muted padding-x-1 hapus-rincian d-flex align-items-center padding-top-1'>
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

// kalo ada inputan nilai_realisasi
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

// begitu rincian biaya di simpan
$(document).delegate('#simpan-rincian-biaya', 'click', function (evt) {
    getFormData();
    loadPdf(`${baseUrl}/pengajuan/preview/${input.get('jenis_pengajuan')}`);
})



// begitu inputannya disimpan
$('#toolbar-simpan').click(function (evt) {
    evt.preventDefault();
    questionMessage("Pesan", "Form Pengajuan ini akan disimpan, apakah anda yakin ?")
        .then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                const data = getFormData();
                data.append(getCsrfName(), getCsrfHash());
                $.ajax({
                    url: `${baseUrl}/pengajuan/store/${input.get('jenis_pengajuan')}`,
                    data: data,
                    type: 'POST',
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                }).done(function (response) {
                    resetCsrfToken(response.token);
                    // kalo gagal dihapus
                    if (response.status_code != 200) {
                        warningMessage('Pesan', response.message);
                        return false;
                    }

                    // kalo berhasil dihapus
                    successMessage('Pesan', response.message);
                    table.ajax.reload(null, false);
                    resetAll();

                })

            } else if (result.isDenied) {
                Swal.close();
            }
        })
});