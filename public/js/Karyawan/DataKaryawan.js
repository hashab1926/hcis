$(document).ready(function () {
    datatable({
        element: '#datatable_karyawan',
        url: `./karyawan/get_datatable`,
        dom: `<".d-flex padding-x-1 justify-content-between"<"#head">p>t<".d-flex justify-content-between"<'.margin-left-5 text-muted'i>p><"clear">`,
        language: {
            info: ` _START_ to _END_ of _TOTAL_ entries`
        },
        columns: [
            {
                "sClass": "text-center",
                "data": "id",
                "orderable": false,
                "createdCell": function (td, cellData, rowData, row, col) {
                    $(td).attr('data-table-id', cellData)

                    if (typeof checkedBox != 'undefined' && checkedBox.length > 0) {
                        if (checkedBox.includes(cellData)) {
                            activeRow($(td).parent())
                        }
                    }

                },
                "render": function (data, type, row, meta) {
                    let checked = '';
                    if (typeof checkedBox != 'undefined' && checkedBox.length > 0) {
                        if (checkedBox.includes(data)) {
                            checked = 'checked';
                            $(`#${this.element}`).find(`[data-table-id='${data}']`).css({
                                'border-left': '5px solid #435ebe',
                                'border-top-left-radius': '4px',
                                'border-bottom-left-radius': '4px',

                            });
                        }
                    }

                    const checkbox = `
                    <div class="form-check">
                        <div class="custom-control custom-checkbox">
                            <input ${checked} type="checkbox" class=" hover-pointer form-check-input form-check-primary form-check-glow checkbox-item" name="id[]" id="id_${data}" value="${data}" disabled>
                            <label class="form-check-label" for="id_${data}"></label>
                        </div>
                    </div>
                    `;

                    return checkbox;
                }
            },
            {
                "sClass": "fweight-700 text-md-1",
                "data": "nip",
            },
            {
                "sClass": "text-uppercase  position-relative",
                "data": "nama_karyawan",
                "render": function (data, type, row, meta) {
                    let akun = '';
                    if (row['id_user'] != null)
                        akun = `
                        <div class='position-absolute' style='left:10px; top:31%;'>
                            <div class=''>
                                <span class="material-icons-outlined">
                                    account_circle
                                </span>
                            </div>
                        </div>
                    `;
                    return ` ${akun} <div class='margin-left-4'>${data}</div>`;
                }
            },
            {
                "data": "email",
                "render": function (data) {
                    return `<div class='text-primary fweight-700'>${data}</div>`;
                }
            },
            {
                "sClass": "text-uppercase",
                "data": "nomor_hp",
            },
            {
                "sClass": "text-uppercase",
                "data": "nama_pangkat",
            },
            {
                "sClass": "text-uppercase",
                "data": "nama_jabatan",
            },
            {
                "sClass": "text-uppercase",
                "data": "nama_divisi",

            },


        ],
        createdRow: function (row, data, dataIndex) {
            $(row).addClass(['padding-row', 'item-row']);
        },

    })

    const inputFilter = `
                        <div div class= 'margin-left-3' >
                            <div class="input-group ">
                                <span class="input-group-text border-left-radius bg-white no-border-right" id="basic-addon1">
                                    <div class="material-icons-outlined text-muted " style='opacity:0.8; border-right:0;'>
                                        filter_alt
                                    </div>
                                </span>
                            <input type="text" class="form-control custom-input-height no-border-radius" placeholder="Filter Karyawan" style="border-left:0; padding-left:5px" >
                                <button class="btn btn-primary border-right-radius border border-light d-flex align-items-center padding-x-3" type="button">
                                    <span class="material-icons-outlined" style='transform:rotate(90deg)'>
                                        tune
                                    </span>
                                </button>
                            </div>
                        </div>
    `;



    const wrapper = `
                    <div class= 'd-flex justify-content-between margin-bottom-5' >
                        ${inputFilter}
                    </div>
                        `;

    $('#head').html(wrapper);

});


$('#toolbar-buatakun').click(function (evt) {
    if (checkedBox.length <= 0) {
        warningMessage('Pesan', 'pilih karyawan terlebih dahulu');
        return false;
    }

    const data = checkedBox.join(',');
    document.location = `./user/buat/${encode(data)}`;
})