const indexCheckbox = 1;
var checkedBox = [];
$(document).on('click', `tr.item-row`, function (evt) {
    onChangeCheckbox(this)
})

// tiap ada perubahan pada checkbox
function onChangeCheckbox(that) {
    const checkbox = $(that).find('input.checkbox-item');
    const checked = checkbox.is(':checked')
    if (checked == false) {
        activeRow(that);
        checkbox.attr('checked', 'checked')
        const id = parseInt($(that).find('input.checkbox-item').val());
        if (!checkedBox.includes(id))
            checkedBox.push(id)
    }
    else {
        deActiveRow(that);
        checkbox.removeAttr('checked')
        checkedBox.remove(parseInt($(that).find('input.checkbox-item').val()))
    }

    // show toolbox
    toolbox();
}

function activeRow(that) {
    $(that).addClass('bg-muted');
    $(that).find('td:nth-child(1)').css({
        'border-left': '5px solid #435ebe',
        'border-top-left-radius': '4px',
        'border-bottom-left-radius': '4px',
    });

}

function deActiveRow(that) {
    $(that).removeClass('bg-muted');
    $(that).find('td:nth-child(1)').removeAttr('style');

}


function toolbox() {
    // kalo datanya ada
    if (checkedBox.length > 0) {
        $('#toolbar-table').css('bottom', '0px')
        // update length selected
        $('#count-item-selected').text(checkedBox.length);
    }
    else
        $('#toolbar-table').css('bottom', '-200px')

}

$('input[name=checkbox_all]').change(function (evt) {


    const checkbox = $(document).find('.checkbox-item');
    const tr = checkbox.parents('.padding-row');

    const checkbox_all = $(this);
    const checked = checkbox_all.is(':checked');
    let id;
    // kalo kolom checkbox all nya belum dicentang
    if (checked == true) {
        checkbox.attr('checked', 'checked');
        tr.addClass('bg-muted');
        tr.find('td:nth-child(1)').css({
            'border-left': '5px solid #435ebe',
            'border-top-left-radius': '4px',
            'border-bottom-left-radius': '4px',
        });
        $.each(tr, function (index, td) {
            id = parseInt($(td).find('td:nth-child(1)').attr('data-table-id'));

            // kalo checkbox nya belum pernah dimasukin, maka masukan ke variabel 'checkedBox'
            if (!checkedBox.includes(id))
                checkedBox.push(id);
        })
    }

    // kalo udah dicentang
    else {
        checkbox.removeAttr('checked');
        tr.removeClass('bg-muted');
        tr.find('td:nth-child(1)').removeAttr('style');
        $.each(tr, function (index, td) {
            id = parseInt($(td).find('td:nth-child(1)').attr('data-table-id'));
            checkedBox.remove(id);
        })
    }

    toolbox();
})


function resetAll() {
    checkedBox = [];
    $('#toolbar-table').css('bottom', '-200px')
}