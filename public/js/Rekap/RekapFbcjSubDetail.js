
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
        <td class='padding-3'><input type='text' name='keterangan[]' class='form-control keterangan' placeholder='Keterangan' data-input='yes'></td>
        <td class='padding-3'><input type='text' name='tanggal_bon[]' class='form-control tglbon' placeholder='Tanggal BON' data-input='yes'></td>
        <td class='padding-3'><input type='text' dir="rtl" name='amount_detail[]' class='form-control currency-number currency-number amount_detail' placeholder='Amount Detail' data-input='yes'></td>

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
    dateLightPick();
})

function dateLightPick() {
    const tglBon = $('.tglbon');
    for (let x = 0; x < tglBon.length; x++) {
        new Lightpick({
            field: document.getElementsByClassName('tglbon')[x],
            singleDate: true,
            format: 'DD-MMM-YYYY'
        });
    }
}

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

    dateLightPick();

    select2Request({
        element: 'select[data-name=id_fbcj_detail]',
        placeholder: '- Pilih Dokumen No -',
        url: `${baseUrl}/rekap/fbcj/ajax/data_fbcj/${idFbcj}`,
    });


})

function getFormData() {
    const dokumen = $(document).find('.dokumen');
    let keterangan;
    let inputDokumen;
    let input;
    let data = {};
    let subData = {};
    for (let x = 0; x < dokumen.length; x++) {
        data[x] = {};
        input = dokumen.eq(x).find("[data-input='yes']");
        keterangan = dokumen.eq(x).find("input.keterangan");
        inputDokumen = dokumen.eq(x);
        data[x]['id_fbcj_detail'] = dokumen.eq(x).find("select[name='id_fbcj_detail']").val();
        subData = {};

        for (let y = 0; y < keterangan.length; y++) {
            subData[y] = {
                'keterangan': inputDokumen.find('input.keterangan').eq(y).val(),
                'tglbon': inputDokumen.find('input.tglbon').eq(y).val(),
                'amount_detail': inputDokumen.find('input.amount_detail').eq(y).cleanVal(),
            };

        }

        console.log(subData);
        data[x]['subdetail'] = subData;

    }
    return data;
}

$('button[name=simpan]').click(function (evt) {
    const data = getFormData();
    console.log(JSON.stringify(data))

    questionMessage("Pesan", "Form Fbcj Detail ini akan disimpan, apakah anda yakin ?")
        .then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: `${baseUrl}/rekap/fbcj/sub_store`,
                    data: {
                        id_fbcj: idFbcj,
                        data: JSON.stringify(data),
                        [getCsrfName()]: getCsrfHash()
                    },
                    type: 'POST',
                    dataType: 'json',
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


$(document).delegate('.hapus-dokumen', 'click', function (evt) {
    evt.preventDefault();
    $(this).parents('.dokumen').remove();
    sumGrandTotal();
})