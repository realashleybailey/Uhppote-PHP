import { fetchAPI } from './fetchAPI.js';
import { errorBox, errorModal } from './errorBox';
import { MyError } from './exception.js';

$('#login').submit(async function (e) {
    e.preventDefault();

    var JSONuser = '';
    var bodyParameters = {
        route: {
            path: 'Login',
            module: 'POST'
        },
        data: {
            username: $('#username').val(),
            password: $('#password').val(),
            remember: $('#remember').is(':checked'),
        },
    }

    try {
        JSONuser = await fetchAPI(bodyParameters);
    } catch (err) {

        if (err.code == 1) {
            $('#errorInfo').text(err.message);
            $('#errorInfo').show();
            return;
        }

        $('#errorBox .bodytext').html(err.message);
        errorModal.show();
        return;
    }

    if (typeof (JSONuser.redirect) == 'undefined') {
        $('#errorBox .bodytext').html('There was an error logging in!');
        errorModal.show();
        return;
    }

    window.location.replace(JSONuser.redirect);
})