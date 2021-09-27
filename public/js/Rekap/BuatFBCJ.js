$(document).find('.currency-number').mask('000.000.000.000.000', { reverse: true });

new Lightpick({
    field: document.getElementById('tanggal'),
    singleDate: true,
    format: 'DD-MMM-YYYY'
});

$('#templating-tambah-baris').click(function (evt) {
    evt.preventDefault();
    $('#tbody-isi').append(`
    <tr class='box-shadow'>
        <td class='padding-3'> <select name="rincian[id_bussiness_trans][]" data-name="id_bussiness_trans" class="w-100" style="width: 100%"></select></td>
        <td class='padding-3'><select name="rincian[id_wbs_element][]" data-name="id_wbs_element" class="w-100" style="width: 100%"></select></td>
        <td class='padding-3'><input type='text' dir="rtl" name='rincian[amount][]' class='form-control currency-number currency-number amount' placeholder='Amount'></td>
        <td class='padding-3'><select name="rincian[id_karyawan][]" data-name="id_karyawan" class="w-100" style="width: 100%"></select></td>

        <td class='padding-3 text-center'>
            <button class='no-border no-background text-muted padding-x-1 hapus-baris d-flex align-items-center justify-content-center padding-top-1 w-100'>
                <span class='material-icons-outlined'>
                    highlight_off
                </span>
            </button>
        </td>
    </tr>
    `);

    $(document).find('.currency-number').mask('000.000.000.000.000', { reverse: true });
    select2RekapFbcj();
})

$(document).delegate('.amount', 'change', function (evt) {
    sumAmount();
})

$(document).delegate('.hapus-baris', 'click', function (evt) {
    $(this).parents('tr').remove();
    sumAmount();
})

function sumAmount() {
    let totalAmount = 0;
    $('.amount').each(function (index, input) {
        totalAmount += parseInt($(input).cleanVal());
    })

    $('#total-amount').text(currencyNumber(totalAmount));
}

function getFormData() {
    const form = new FormData($('#form-fbcj')[0]);
    if ($('#form-title-fbcj').length > 0) {

        const formTitleFbcj = new FormData($('#form-title-fbcj')[0]);
        for (var pair of formTitleFbcj.entries()) {
            form.append(pair[0], pair[1]);
        }
    }

    // file upload
    const files = $('#fileUpload')[0].files;
    for (let y = 0; y < files.length; y++) {
        form.append(`bukti_file[${y}]`, files[y]);
    }
    return form;
}

$('button[name=simpan]').click(function (evt) {
    const data = getFormData();
    data.append(getCsrfName(), getCsrfHash());
    questionMessage("Pesan", "Form Fbcj ini akan disimpan, apakah anda yakin ?")
        .then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: `${baseUrl}/rekap/fbcj/store`,
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
                    document.location = response.action;
                });
            } else if (result.isDenied) {
                Swal.close();
            }
        })
})



// upload 'kartik-upload'+
$("#fileUpload").fileinput({
    showUpload: false,
    dropZoneEnabled: true,
    mainClass: "d-none",
});
$('.file-preview').addClass(['no-border']);