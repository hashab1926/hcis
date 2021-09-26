$(document).ready(function () {
    datatable({
        element: '#datatable',
        url: `${baseUrl}/pengajuan/inbox/get_datatable`,
        dom: `<".d-flex padding-x-1 justify-content-between"<"#head">p>t<".d-flex justify-content-between"<'.margin-left-5 text-muted'i>p><"clear">`,
        language: {
            info: ` _START_ to _END_ of _TOTAL_ entries`
        },
        columns: [

            {
                "data": "id",
                "createdCell": function (td, cellData, rowData, row, col) {
                    $(td).attr('width', '30%')

                },
                "render": function (data, type, row, meta) {
                    const namaPengaju = ucFirst(row['nama_pengaju'].toLowerCase());
                    const nomor = row['nomor'] ?? 'Belum diisi';
                    const avatar = `
                    <div class='d-flex align-items-center'>
                        <div class='d-flex align-items-center'>
                            <span class="material-icons-outlined icon-lg-title text-muted">
                                account_circle
                            </span>
                            <div class='d-flex flex-column margin-top-1 margin-left-2'>
                                <div class='fweight-700 text-sm-4 text-primary'>${namaPengaju}</div>
                                <small class='text-muted'>Nomor ${nomor}</small>
                            </div>
    
                        </div>
                    </div>

                    `;
                    return `
                    <div class='d-flex'>
                        ${avatar}
                    </div>
                    `;
                }
            },
            {
                "data": "nama_pengaju",
                "createdCell": function (td, cellData, rowData, row, col) {
                    $(td).attr('width', '40%')

                },
                "render": function (data, type, row, meta) {
                    return `
                                <div class=''>
                                    <div class='d-flex align-items-center'>
                                        ${iconNamaJenis(row['nama_jenis'])}
                                        <div class='margin-left-2'>${namaJenis(row['nama_jenis'])}</div>
                                    </div>
                                </div>
    
                        `;
                }
            },
            {
                "data": "status",
                "createdCell": function (td, cellData, rowData, row, col) {
                    $(td).attr('width', '20%')

                },
                "render": function (data, type, row, meta) {
                    return `
                    <div class=''>
                    <div class='d-flex align-items-center'>
                        ${iconStatus(row['status'])}
                        <div class='margin-left-2'>${textStatus(row['status'])}</div>
                    </div>
                </div>
                    `;
                }
            },
            {
                "data": "created_at",
                "createdCell": function (td, cellData, rowData, row, col) {
                    $(td).attr('width', '15%')

                },
                "render": function (data, type, row, meta) {
                    return data;
                }
            }

        ],
        createdRow: function (row, data, dataIndex) {
            $(row).addClass(['padding-row', 'bg-white']);
            $(row).attr('data-id', data['id'])
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
    // $('#datatable thead').remove(); s

    $(document).delegate('#datatable tbody tr', 'click', function (evt) {
        document.location = `${baseUrl}/pengajuan/detail/${$(this).attr('data-id')}`;
    })
});
