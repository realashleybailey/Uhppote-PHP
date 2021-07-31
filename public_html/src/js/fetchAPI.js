import 'whatwg-fetch';

export async function fetchAPI(bodyParameters, userauth = false) {

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

    if (errorBody.error != 'undefined') {
        throw {
            message: errorBody.error.message,
            code: errorBody.error.type,
            line: errorBody.error.line,
            file: errorBody.error.file
        }
    }

    throw new Error(errorBody);
}