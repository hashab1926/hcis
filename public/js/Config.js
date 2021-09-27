var table = null;
var buttonHtml = '';
var project = window.location.pathname.split('/')[1]
const host = window.location.hostname;
var baseUrl = window.location.origin;
var dataPdf = {};
var dataCustomPdf = null;
if (host != 'localhost')
    baseUrl += "/project";

// var previewUpload = '<object class="kv-preview-data file-preview-' + e + '" title="{caption}" data="{data}" type="' + i + '"' + B + ">\n" + t.DEFAULT_PREVIEW + "\n</object>\n";
async function datatable(options) {
    table = await $(options.element).DataTable({
        "processing": true,
        "serverSide": true,
        "dom": options.dom ?? '',
        "ajax": options.url ?? '',
        "deferRender": true,
        "language": {
            "info": options.language.info ?? "Showing _START_ to _END_ of _TOTAL_ entries",

            'paginate': {
                'previous':
                    `<span class="material-icons-outlined icon-title">
                    keyboard_arrow_left
                 </span>`,
                'next':
                    `<span class="material-icons-outlined icon-title">
                        keyboard_arrow_right
                    </span>`
            }
        },
        "pagingType": 'simple',
        "pageLength": 10,
        "createdRow": options.createdRow ?? false,
        "columns": options.columns,
        "fnServerParams": function (aoData) {
            const limit = aoData.length;
            const offset = aoData.start;
            if (offset <= 0)
                aoData.page = 1;
            else
                aoData.page = offset / limit + 1;

        },

    });

    if ($("input[name=datatable_cari]").length > 0) {
        $("input[name='datatable_cari']").on('keyup', function (evt) {
            table.search($(this).val()).draw();
        })
    }
}

function isEmpty(obj) {
    for (var prop in obj) {
        if (obj.hasOwnProperty(prop)) {
            return false;
        }
    }

    return JSON.stringify(obj) === JSON.stringify({});
}

function ucFirst(string) {
    string = string.toLowerCase();
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function getCsrfName() {
    return $('#csrf_token').attr('name');
}

function getCsrfHash() {
    return $('#csrf_token').attr('content');
}

function resetCsrfToken(newToken) {
    return $('#csrf_token').attr('content', newToken);
}

function enableLoading(name) {
    const button = $(`button[name=${name}]`);
    buttonHtml = button.html();
    button.html(`<div class="spinner-border" role="status"><span class="sr-only"></span></div>`);
    button.attr('disabled', 'true');

}
function currencyNumber(bilangan) {
    let reverse = bilangan.toString().split('').reverse().join(''),
        ribuan = reverse.match(/\d{1,3}/g);
    ribuan = ribuan.join('.').split('').reverse().join('');

    return ribuan;
}

function loadingOn() {
    $('#loading-page').css('display', 'block')
}

function loadingOff() {
    $('#loading-page').css('display', 'none')
}

function errorMessage(jqXHR, exception) {
    var msg = '';
    if (jqXHR.status === 0) {
        msg = 'Not connect.\n Verify Network.';
    } else if (jqXHR.status == 404) {
        msg = 'Requested page not found. [404]';
    } else if (jqXHR.status == 500) {
        msg = 'Internal Server Error [500].';
    } else if (exception === 'parsererror') {
        msg = 'Requested JSON parse failed.';
    } else if (exception === 'timeout') {
        msg = 'Time out error.';
    } else if (exception === 'abort') {
        msg = 'Ajax request aborted.';
    } else {
        msg = 'Uncaught Error.\n' + jqXHR.responseText;
    }

    warningMessage("Pesan", msg);
}
function disableLoading(name, value) {
    $(`button[name=${name}]`).html(value);
    $(`button[name=${name}]`).removeAttr('disabled');
}

function successMessage(title = 'Pesan', message) {
    Swal.fire({
        title: title,
        text: message,
        icon: 'success',
        confirmButtonText: 'OKE'
    })
}

function warningMessage(title = 'Pesan', message) {
    Swal.fire({
        title: title,
        text: message,
        icon: 'warning',
        confirmButtonText: 'OKE'
    })
}

function questionMessage(title = 'Pesan', message, icon = 'question', confirmButtonText = 'Ya, saya yakin') {
    return Swal.fire({
        title: title,
        icon: icon,
        text: message,
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: confirmButtonText,
        denyButtonText: `Tidak`,
    })
}

Array.prototype.remove = function () {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};

function encode(string) {
    return btoa(string).replace(/\=/ig, '');
}

function decode(encode) {
    return atob(encode);
}


function formatSelection(state) {
    if (!state.id)
        return state.text;

    var $state = $(
        '<span><span></span></span>'
    );
    // Use .text() instead of HTML string concatenation to avoid script injection issues
    $state.find("span").addClass(['text-size-1', 'fweight-600']);
    $state.find("span").text(state.text);

    return $state;
}

// format select2
function formatState(state) {
    if (!state.id)
        return state.text;

    var $state = $(
        `<span>${state.text}</span>`
    );

    return $state;
};

function select2Request(options) {

    if (typeof $(`${options.element}`).select2 == "undefined") return false;

    let config = {
        dropdownCssClass: options.fixed == true ? 'increasezindex' : '',
        templateResult: formatState,
        templateSelection: formatSelection,
        placeholder: options.placeholder,

        ajax: {
            url: `${options.url}`,
            dataType: 'json',
            data: function (params) {
                var query = {
                    search: params.term,
                    page: params.page || 1
                }
                // Query parameters will be ?search=[term]&type=public
                return query;
            },

            // hasil dari request 
            processResults: function (data, params) {
                params.page = params.page || 1;

                return {
                    results: data.results,
                    pagination: {
                        more: (params.page * 10) < data.count_filtered
                    }
                };
            }
        }
    };
    if (options.indexElement == null)
        return $(`${options.element}`).select2(config);
    else
        return $(`${options.element}`).eq(options.indexElement).select2(config);

}
function objToGet(obj) {
    let tampung = '?';
    if (obj != null) {
        Object.keys(obj).forEach(function (key) {
            if (obj[key] != '')
                tampung += `${key}=${obj[key]}&`;
        });
    }
    return tampung;
}

function namaJenis(nama) {
    let text = '';
    switch (nama) {
        case 'PD_LKOTA': text = 'Surat perjalanan dinas luar kota'; break;
        case 'PD_DKOTA': text = 'Surat perjalanan dinas dalam kota'; break;
        case 'PD_LNGRI': text = 'Surat perjalanan dinas luar negri'; break
        case 'RE_FASKOM': text = 'Reimburse Fasilitas Komunikasi'; break;
        case 'CUTI': text = 'Surat Pengajuan Cuti Karyawan'; break;
        case 'LEMBUR': text = 'Surat Pengajuan Lembur Karyawan'; break;

    }

    return text;
}

function iconNamaJenis(nama) {
    let text = '';
    switch (nama) {
        case 'PD_LKOTA': text = `<span class="material-icons-outlined icon-lg-title">emoji_transportation</span>`; break;
        case 'PD_DKOTA': text = `<span class="material-icons-outlined icon-lg-title">directions_car</span>`; break;
        case 'PD_LNGRI': text = `<span class="material-icons-outlined icon-lg-title">flight_takeoff</span>`; break;

        case 'RE_FASKOM': text = `<span class="material-icons-outlined icon-lg-title">paid</span>`; break;
        case 'CUTI': text = `<span class="material-icons-outlined icon-lg-title">hail</span>`; break;
        case 'LEMBUR': text = `<span class="material-icons-outlined icon-lg-title">work</span>`; break;

    }

    return text;
}

function iconStatus(status) {
    let text = '';
    switch (status) {
        case 'PROSES': text = `<span class="material-icons-outlined icon-lg-title">loop</span>`; break;
        case 'ACC': text = `<span class="material-icons-outlined icon-lg-title">how_to_reg</span>`; break;
        case 'SELESAI': text = `<span class="material-icons-outlined icon-lg-title text-success">verified</span>`; break;
        case 'TOLAK': text = `<span class="material-icons-outlined icon-lg-title text-danger">highlight_off</span>`; break;

    }

    return text;
}

function textStatus(status) {
    let text = '';
    switch (status) {
        case 'PROSES': text = `<span class='text-muted'>Sedang diproses</span>`; break;
        case 'ACC': text = `<span class='text-muted'>Acc</span>`; break;
        case 'SELESAI': text = `<span class='text-success'>Selesai</span>`; break;
        case 'TOLAK': text = `<span class='text-danger'>Ditolak</span>`; break;

    }

    return text;
}


var signatures = {
    JVBERi0: "application/pdf",
    R0lGODdh: "image/gif",
    R0lGODlh: "image/gif",
    iVBORw0KGgo: "image/png"
};

function detectMimeType(b64) {
    for (var s in signatures) {
        if (b64.indexOf(s) === 0) {
            return signatures[s];
        }
    }
}