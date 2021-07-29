$('#store-login').submit(function (evt) {
    evt.preventDefault();
    let data = new $(this).serializeArray();
    $.ajax({
        url: './login/store',
        data: data,
        dataType: 'json',
        method: 'POST',
        beforeSend: function () {
            enableLoading('login')
        }
    }).done(function (response) {
        resetToken(response.token);
        disableLoading('login', 'Log in');

        if (response.status_code == 200)
            document.location = response.action;
        else
            warningMessage('Pesan', response.message);
    })
})

function resetToken(token) {
    $('#csrf_token').val(token);
}