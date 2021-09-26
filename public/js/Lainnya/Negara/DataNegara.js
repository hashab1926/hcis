$(document).ready(function () {
    datatable({
        element: '#datatable',
        url: `${baseUrl}/negara/get_datatable`,
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
                "sClass": "text-uppercase",
                "data": "nama_negara",

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