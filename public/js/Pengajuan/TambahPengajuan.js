var input = new URLSearchParams(window.location.search);
$('#jenis_pengajuan').change(function (evt) {
    const value = $(this).val();
    document.location = `?jenis_pengajuan=${value}`;
})
$('#biaya_perjalanan_dinas').change(function (evt) {
    const status = $(this).is(':checked');
    if (status == true) {
        $('#wrapper-rincian-biaya').removeClass('d-none');
        $('#label_biaya_perjalanan_dinas').text("Non aktif");
    }
    else {
        $('#label_biaya_perjalanan_dinas').text("Aktif");
        $('#wrapper-rincian-biaya').addClass('d-none');
    }

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

function updateNilaiPengajuan() {
    let sumPengajuan = 0;
    $(document).find('.nilai_pengajuan').each(function (index, value) {
        sumPengajuan += parseInt($(value).cleanVal());
    })

    return sumPengajuan;
}

function getFormData() {
    const formPengajuan = new FormData($('#form-pengajuan')[0]);
    if ($('#form-rincianbiaya').length > 0) {

        const formRincianBiaya = new FormData($('#form-rincianbiaya')[0]);
        for (var pair of formRincianBiaya.entries()) {
            formPengajuan.append(pair[0], pair[1]);
        }
    }
    formPengajuan.append('nama_jenis', $('input[name=nama_jenis]').val());
    formPengajuan.append('templating[nama_penandatangan]', $('#penandatangan').val());
    return formPengajuan;
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
            <td class='padding-3'><input type='text'input dir="rtl" name='templating[nilai_pengajuan][]' class='form-control currency-number currency-number nilai_pengajuan no-border' placeholder='Nominal'></td>
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

// kalo ada button hapus rincian
$(document).delegate('.hapus-rincian', 'click', function (evt) {
    $(this).parents('tr').remove();

    $('#total-nilai-pengajuan').text(currencyNumber(updateNilaiPengajuan()));

})


var saclar = false;
$('#btn-expand').click(function (evt) {
    if (saclar == false) {
        $('#wrapper-pengajuan').removeClass('col-lg-8');
        $('#wrapper-pengajuan').addClass('col-lg-12');

        saclar = true;
    } else {
        $('#wrapper-pengajuan').addClass('col-lg-8');
        $('#wrapper-pengajuan').removeClass('col-lg-12');
        saclar = false;

    }

});