
// ========================================================= [ LAMPIRAN ] =========================================================
pluginDatelightPick();
function pluginDatelightPick() {
    const dateLengthLampiran = $(document).find('.datelightpick-tanggal').length;
    if (dateLengthLampiran > 0) {

        for (let x = 0; x < dateLengthLampiran; x++) {
            new Lightpick({
                field: document.getElementsByClassName('datelightpick-tanggal')[x],
                format: 'DD-MM-YYYY'
            });
        }
    }
}



// kalo ada buttom Tambah rincian 
if ($('#templating-lampiran-tambah-rincian').length > 0) {
    $('#templating-lampiran-tambah-rincian').click(function (evt) {
        evt.preventDefault();
        let no = $('#tbody-rincian-bukti tr').length + 1;
        $('#tbody-rincian-bukti').append(`
        <tr class='box-shadow'>
            <td class='padding-3 text-center nomor-rincian'>${no}</td>
            <td class='padding-3'><input type='text' name='templating_lampiran[tanggal][]' class='form-control no-border text-muted datelightpick-tanggal' placeholder='Tanggal'></td>
            <td class='padding-3'><input type='text' name='templating_lampiran[uraian][]' class='form-control no-border text-muted' placeholder='Uraian'></td>
            <td class='padding-3'><input type='number' name='templating_lampiran[jumlah][]' value='1' class='form-control no-border text-muted jumlah-perrincian' placeholder='Jumlah'></td>
            <td class='padding-3'>
                <select name='templating_lampiran[satuan][]' class='form-select'>
                    <option value="bon">Bon</option>
                </select>
            </td>
            <td class="padding-3">
                <input type='text' dir="rtl" name='templating_lampiran[harga_satuan][]' class='form-control currency-number currency-number harga_satuan no-border' placeholder='Nominal'>
            </td>
            <td class="padding-3 total_row_rincian" style='text-align:right'>0</td>

            <td class='padding-3 text-center'>
                <button class='no-border no-background text-muted padding-x-1 hapus-rincian-bukti d-flex align-items-center justify-content-center padding-top-1 w-100'>
                    <span class='material-icons-outlined'>
                        highlight_off
                    </span>
                </button>
            </td>
        </tr>
        `);

        $(document).find('.currency-number').mask('000.000.000.000.000', { reverse: true });
        pluginDatelightPick();

    })
}

// kalo ada button hapus rincian
$(document).delegate('.hapus-rincian-bukti', 'click', function (evt) {
    $(this).parents('tr').remove();

    $('#total-rincian-bukti').text(currencyNumber(updateTotalNilai()));
    $('#biaya').text(currencyNumber(updateTotalNilai()));
    $('#biaya_input').val(currencyNumber(updateTotalNilai()));

    $('.nomor-rincian').each(function (index, item) {
        $(item).text(index + 1);
    })
})

function updateTotalNilai() {
    let sumTotal = 0;
    let hargaSatuan = 0;
    let jumlah = 0;
    $(document).find('.harga_satuan').each(function (index, value) {
        hargaSatuan = parseInt($(value).val() == '' ? 0 : $(value).cleanVal());
        jumlah = parseInt($('.jumlah-perrincian').eq(index).val() == '' ? 0 : $('.jumlah-perrincian').eq(index).val());
        sumTotal += hargaSatuan * jumlah;
    })


    return sumTotal;
}

function updateNilai(index) {
    if (($('.harga_satuan').eq(index).val() == '')) return false;

    const hargaSatuan = parseInt($('.harga_satuan').eq(index).cleanVal());
    const jumlah = parseInt($('.jumlah-perrincian').eq(index).val());
    const total = currencyNumber(jumlah * hargaSatuan);
    $('.total_row_rincian').eq(index).text(total);
}
// kalo ada inputan nilai_pengajuan
if ($('.harga_satuan').length > 0) {
    $(document).delegate('.harga_satuan', 'change', function (evt) {
        const index = $('.harga_satuan').index(this);
        updateNilai(index);
        const totalNilai = updateTotalNilai();
        $('#total-rincian-bukti').html(currencyNumber(totalNilai));
        $('#biaya').text(currencyNumber(totalNilai));
        $('#biaya_input').val(currencyNumber(totalNilai));

    })
}



// upload 'kartik-upload'+
$("#fileUpload").fileinput({
    showUpload: false,
    dropZoneEnabled: true,
    mainClass: "d-none",
});
$('.file-preview').addClass(['no-border']);

function getFormData() {
    const formTemplating = new FormData($(document).find('#form-templating')[0]);
    const formLampiran = new FormData($(document).find('#form-templating-lampiran')[0]);

    for (var pair of formLampiran.entries()) {

        formTemplating.append(pair[0], pair[1]);
    }

    // file upload
    const files = $('#fileUpload')[0].files;
    for (let y = 0; y < files.length; y++) {
        formTemplating.append(`bukti_file[${y}]`, files[y]);
    }
    return formTemplating;
}


$('button[name=simpan]').click(function (evt) {
    const data = getFormData();
    let id = (window.location.href).split('/');
    id = id[id.length - 1];
    data.append('id', id)
    data.append(getCsrfName(), getCsrfHash());
    questionMessage("Pesan", "Form Pengajuan & lampiran ini akan disimpan, apakah anda yakin ?")
        .then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: `${baseUrl}/pengajuan/lampiran/store`,
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
                    if (response.status_code != 200) {
                        warningMessage('Pesan', response.message);
                        return false;
                    }

                    // kalo berhasil dihapus
                    successMessage('Pesan', response.message);
                    document.location = response.action;
                });
            } else if (result.isDenied) {
                Swal.close();
            }
        })
})

