$('#cari-karyawan').on('keyup', function (evt) {
    // kalo keyword yg diketik < 2 huruf
    const search = $(this).val();
    if (search.length < 2) {
        hideAutoComplete();
        return false;
    }


    showAutoComplete();
    searchData(search);
})

$('#cari-karyawan').on('click', function (evt) {
    showAutoComplete();
    searchData();
});

$('#cari-karyawan').val('');
var param = {};
var idUser = null;
$(document).delegate('.autocomplete-search .item', 'click', function (evt) {
    const id = $(this).attr('data-id');
    const nama = $(this).attr('data-name');
    $('#cari-karyawan').val(nama);
    idUser = id;
    hideAutoComplete();
})

$('#search').click(function (evt) {
    const tglAwal = $('input[name=tgl_awal]').val();
    const tglAkhir = $('input[name=tgl_akhir]').val();

    if (tglAwal != "" && tglAkhir != "") {

        param.tgl_awal = tglAwal;
        param.tgl_akhir = tglAkhir;
    }

    if (idUser == null) {
        alert('silahkan isi nama karyawan');
        return false;
    }
    document.location = `${baseUrl}/rekap/preview/${idUser}${objToGet(param)}`
})

$(document).delegate('body', 'click', function (evt) {
    if ($(evt.target).attr('id') != 'cari-karyawan')
        hideAutoComplete();
})
function searchData(search = '') {
    $.ajax({
        url: `${baseUrl}/karyawan/get?q=${search}`,
        type: 'GET',
        dataType: 'json',
        beforeSend: function () {
            showLoadingAutocomplete();
        }
    }).done(function (response) {
        let html = '';
        if (response.status_code != 200) {
            html += `
            <div class='text-center'>
                <div>${response.message}</div>
            </div>
            `;

        } else {
            html += showDataAutocomplete(response.results);
        }

        $('.autocomplete-search').html(html);
    });
}

function showDataAutocomplete(data) {
    let html = '';
    let x = 0;
    while (typeof data[x] != 'undefined') {

        html += `
        <div class="item d-flex align-items-center justify-content-between" href="#" data-id='${data[x]['id_user']}' data-name='${data[x]['nama']}'>            
            <div class="d-flex align-content-center">
                <div class='item-icon'>
                    <span class="material-icons-outlined icon-lg-title">
                        person_outline
                    </span>
                </div>
                <div class='d-flex flex-column'>
                    <div class='item-text fweight-700'>${data[x]['nama']}</div>
                    <div class='subitem-text text-sm-4 text-muted'>${data[x]['nip']} &nbsp; ${data[x]['pangkat']}</div>
                </div>
            </div>

            <div>
                <span class='badge bg-primary text-white'>3</span>
            </div>
        </div>
        `;
        x++;
    }
    if (data.length <= 0)
        html += `
        <div class='text-center padding-y-3 text-muted d-flex align-items-center justify-content-center'>
            <span class="material-icons-outlined">
                person_search
            </span>
            <div>Karyawan tidak ditemukan</div> 
        </div>`;
    return html;
}

function showLoadingAutocomplete() {
    $('.autocomplete-search').html(`
        <div class='text-center'>
            <div class="spinner-border" role="status">
                <span class="sr-only"></span>
            </div>
        </div>
    `);
}

function showAutoComplete() {
    $('.autocomplete-search').css({
        display: 'block',
    });
}

function hideAutoComplete() {
    $('.autocomplete-search').css({
        display: 'none',
    });
}

$('#cari').click(function (evt) {
    const tglAwal = $('input[name=tgl_awal]').val();
    const tglAkhir = $('input[name=tgl_akhir]').val();

    if (tglAwal != "" && tglAkhir != "") {

        param.tgl_awal = tglAwal;
        param.tgl_akhir = tglAkhir;
    }

    document.location = `${baseUrl}/rekap/preview_perdin${idUser != null ? `/${idUser}` : ''}${objToGet(param)}`
})