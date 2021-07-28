if ($('#errorBox').length > 0) {
    const errorBox = $('#errorBox');
    const errorModal = new mdb.Modal(errorBox);
}

$('#login').submit(async function (e) {
    e.preventDefault();

    bodyParameters = {
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
    } catch ($e) {
        $('#errorBox .bodytext').html($e);
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

async function fetchAPI(bodyParameters, userauth = false) {

    if (!window.authToken) {
        throw new Error('Auth Token not provided for API call');
    }

    var USER_AUTHORIZATION = '';

    if (userauth) {
        USER_AUTHORIZATION = {
            USER_AUTHORIZATION: userToken
        }
    }

    const body = JSON.stringify(bodyParameters);
    const fetchRequest = await fetch('/api/', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            USER_AUTHORIZATION,
            'HTTP_AUTHORIZATION': 'Bearer ' + authToken,
            'Host': 'ashleybailey.me'
        },
        body,
    });

    if (fetchRequest.ok) {
        return fetchRequest.json();
    }

    const errorBody = await fetchRequest.json();
    throw new Error(errorBody.error.message + ' on line ' + errorBody.error.line + ' in ' + errorBody.error.file);
}