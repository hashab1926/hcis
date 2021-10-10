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
            format: 'DD-MM-YYYY'
        });
    }
}

if ($('#datelightpick-lama-cuti').length > 0) {
    new Lightpick({
        field: document.getElementById('datelightpick-lama-cuti'),
        singleDate: false,
        numberOfMonths: 2,
        format: 'DD-MM-YYYY'
    });
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
            <td class='padding-3'><select name="templating[jenis_fasilitas][]" data-name="jenis_fasilitas" class="w-100" style="width: 100%"></select></td>
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
        select2Request({
            element: `select[data-name='jenis_fasilitas']`,
            placeholder: '- Pilih Jenis Fasilitas -',
            url: `${baseUrl}/jenis_fasilitas/ajax/data_jenis_fasilitas_nama`
        })


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



// begitu inputannya disimpan
$('button[name=simpan]').click(function (evt) {
    evt.preventDefault();
    questionMessage("Pesan", "Form Pengajuan ini akan disimpan, apakah anda yakin ?")
        .then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                const data = getFormData();
                data.append('nama_jenis', input.get('jenis_pengajuan'));
                data.append(getCsrfName(), getCsrfHash());
                $.ajax({
                    url: `${baseUrl}/pengajuan/store`,
                    data: data,
                    type: 'POST',
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        loadingOn();
                    },
                    error: function (jqXHR, exception) {
                        loadingOff();
                        errorMessage(jqXHR, exception);
                    },
                }).done(function (response) {
                    loadingOff();

                    resetCsrfToken(response.token);
                    // kalo gagal dihapus
                    if (response.status_code != 201) {
                        warningMessage('Pesan', response.message);
                        return false;
                    }

                    // kalo berhasil dihapus
                    successMessage('Pesan', response.message);
                    location.reload();
                })

            } else if (result.isDenied) {
                Swal.close();
            }
        })
});

if ($('#tgllembur').length > 0) {
    new Lightpick({
        field: document.getElementById('tgllembur'),
        format: 'DD-MMM-YYYY'
    });

}

$('.jenis_pengajuan').click(function (evt) {
    const value = $(this).attr('data-value');
    document.location = `?jenis_pengajuan=${value}`;
})

var saclarSidebar = true;
if (saclarSidebar == false) {
    $('#sidebar-right-pengajuan').css('right', '-300px');
    $('#button_showhide').css('right', '0px');
    $('#icon-showhide').text('chevron_left');
}
$('#button_showhide').click(function (evt) {
    if (saclarSidebar == false) {

        $('#sidebar-right-pengajuan').css('right', '0px');
        $('#button_showhide').css('right', '300px');
        $('#icon-showhide').text('chevron_right');

        saclarSidebar = true;
    } else {
        $('#sidebar-right-pengajuan').css('right', '-300px');
        $('#button_showhide').css('right', '0px');
        $('#icon-showhide').text('chevron_left');
        saclarSidebar = false;

    }
})
console.log($('input'))
$(`input[name='templating[lama_lembur]'`).change(function (evt) {
    if ($(this).val() > 3)
        $(this).val(3);
})