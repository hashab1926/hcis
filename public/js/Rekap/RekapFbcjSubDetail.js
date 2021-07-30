
const idFbcj = $('div#id-fbcj').attr('data-id');
const contentTable = $('#form-fbcj-subdetail').html();
$(document).find('.currency-number').mask('000.000.000.000.000', { reverse: true });
select2Request({
    element: 'select[data-name=id_fbcj_detail]',
    placeholder: '- Pilih Dokumen No -',
    url: `${baseUrl}/rekap/fbcj/ajax/data_fbcj/${idFbcj}`,
});


new Lightpick({
    field: document.getElementsByClassName('tglbon')[0],
    singleDate: true,
    format: 'DD-MMM-YYYY'
});

$(document).delegate('.tambah-baris', 'click', function (evt) {
    const index = $('.tambah-baris').index(this);
    evt.preventDefault();
    const length = $('.tbody-isi').eq(index).children('tr').length;
    $('.tbody-isi').eq(index).append(`
    <tr class='box-shadow'>
        <td class='padding-3 text-center'>${length + 1}</td>
        <td class='padding-3'><input type='text' name='subdetail[keterangan][]' class='form-control' placeholder='Keterangan'></td>
        <td class='padding-3'><input type='text' name='subdetail[tanggal_bon][]' class='form-control tglbon' placeholder='Tanggal BON'></td>
        <td class='padding-3'><input type='text' dir="rtl" name='subdetail[amount_detail][]' class='form-control currency-number currency-number amount_detail' placeholder='Amount Detail'></td>

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

    const tglBon = $('.tglbon');
    for (let x = 0; x < tglBon.length; x++) {
        new Lightpick({
            field: document.getElementsByClassName('tglbon')[x],
            singleDate: true,
            format: 'DD-MMM-YYYY'
        });
    }


})

$(document).delegate('.amount_detail', 'change', function (evt) {
    const indexDokumen = $(this).parents('.dokumen').index();
    sumAmount(indexDokumen);
    sumGrandTotal();
})

$(document).delegate('.hapus-baris', 'click', function (evt) {
    const indexDokumen = $(this).parents('.dokumen').index();

    $(this).parents('tr').remove();
    sumAmount(indexDokumen);
    sumGrandTotal();
})

function sumAmount(indexDokumen) {
    let totalAmount = 0;
    $('.dokumen').eq(indexDokumen).find('.amount_detail').each(function (index, input) {
        totalAmount += parseInt($(input).val() == '' ? 0 : $(input).cleanVal());

    })

    // hitung total amount
    $('.dokumen').eq(indexDokumen).find('.total-amount').text(currencyNumber(totalAmount));
    return totalAmount;

}
function sumGrandTotal() {
    const dokumen = $('.dokumen');
    let grandTotalAmount = 0;
    for (let x = 0; x < dokumen.length; x++) {
        grandTotalAmount += sumAmount(x);
    }
    // hitung grand total amount
    $('#grandtotal-amount').text(currencyNumber(grandTotalAmount));
}
$('#tambah-dokumen').click(function (evt) {
    const content = contentTable;
    const lastDokumen = $('#form-fbcj-subdetail .dokumen').length;
    $('#form-fbcj-subdetail').append(content);
    $(document).find('.currency-number').mask('000.000.000.000.000', { reverse: true });
    const length = $('.tbody-isi').eq(lastDokumen).children('tr').length;
    new Lightpick({
        field: document.getElementsByClassName('tglbon')[length],
        singleDate: true,
        format: 'DD-MMM-YYYY'
    });

    select2Request({
        element: 'select[data-name=id_fbcj_detail]',
        placeholder: '- Pilih Dokumen No -',
        url: `${baseUrl}/rekap/fbcj/ajax/data_fbcj/${idFbcj}`,
    });
})

$('button[name=simpan]').click(function (evt) {
    const data = new FormData($('#form-fbcj-subdetail')[0]);
    data.append(getCsrfName(), getCsrfHash());
    questionMessage("Pesan", "Form Fbcj Detail ini akan disimpan, apakah anda yakin ?")
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
                        enableLoading('tambah')
                    },
                }).done(function (response) {
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