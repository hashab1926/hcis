$(document).ready(function () {
    datatable({
        element: '#datatable',
        url: `${baseUrl}/rekap/fbcj/get_datatable`,
        dom: `<".d-flex padding-x-1 justify-content-between"<"#head">p>t<".d-flex justify-content-between"<'.margin-left-5 text-muted'i>p><"clear">`,
        language: {
            info: ` _START_ to _END_ of _TOTAL_ entries`
        },
        columns: [
            {
                "sClass": "",
                "data": "nomor",
                "render": function (data) {
                    return `Nomor.${data ?? 'tidak diketahui'}`;
                }
            },

            {
                "sClass": "",
                "data": "nama_divisi",
            },

            {
                "sClass": "",
                "data": "kas_jurnal",
            },

            {
                "sClass": "",
                "data": "kode_cost_center",

            },
            {
                "sClass": "d-flex",
                "data": "aksi",
                "render": function (data, type, row) {
                    return `
                    <button onclick="document.location='${baseUrl}/rekap/fbcj/detail/${row['id']}'" class='btn btn-primary d-flex align-items-center'>
                                <span class="material-icons-outlined">
                                    format_list_bulleted
                                </span>
                                <div class='margin-left-2'>Detail</div>
                    </button>

                            `;
                }
            },

        ],
        createdRow: function (row, data, dataIndex) {
            $(row).addClass(['padding-row', 'item-row']);
        },

    })

    const inputFilter = `
    <div class='margin-left-3'>
        <div class="input-group ">
            <span class="input-group-text border-left-radius bg-white no-border-right" id="basic-addon1">
                <div class="material-icons-outlined text-muted " style='opacity:0.8; border-right:0;'>
                    filter_alt
                </div>
            </span>
            <input type="text" class="form-control custom-input-height no-border-radius" placeholder="Cari" style="border-left:0; padding-left:5px"  name='datatable_cari'>
            <button class="btn btn-primary border-right-radius border border-light d-flex align-items-center padding-x-3" type="button">
                <span class="material-icons-outlined" style='transform:rotate(90deg)'>
                    tune
                </span>
            </button>
        </div>
    </div>
    `;

    const buttonAdd = `
        <div>
            <button class='btn btn-primary d-flex align-items-center border-radius padding-y-2 padding-x-3'>
                <span class="material-icons-outlined icon-primary">
                    add
                </span>
                <div class='margin-left-2 margin-right-2'>Buat Baru</div>
            </button>
        </div>
    `;

    const wrapper = `
    <div class='d-flex justify-content-between margin-bottom-5'>
        ${inputFilter}
    </div>
    `;

    $('#head').html(wrapper);
});