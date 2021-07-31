import { fetchAPI } from './fetchAPI.js';
import { errorBox, errorModal } from './errorBox';

$('#searchUhppote').click(async function () {
    var JSONsearch = '';
    var bodyParameters = {
        route: {
            path: 'Uhppote',
            module: 'Search'
        }
    }

    try {
        JSONsearch = await fetchAPI(bodyParameters);
    } catch ($e) {
        $('#errorBox .bodytext').html($e);
        errorModal.show();
        return;
    }

    var html = '';

    for (var i in JSONsearch.body) {

        var item = JSONsearch.body[i];

        html += "" +
            "<tr>" +
            "<th scope=\"row\">" + i + "</th>" +
            "<td>" + item.sn.toUpperCase() + "</td>" +
            "<td>" + item.ip + "</td>" +
            "<td>" + item.mac.replaceAll('-', ':') + "</td>" +
            "<td>" + item.mask + "</td>" +
            "<td>" + item.gate + "</td>" +
            "<td>" +
            "<button type=\"button\" id=\"addController\" class=\"btn btn-success btn-sm px-3\">" +
            "<i class=\"fas fa-plus\"></i>" +
            "</button>" +
            "</td>" +
            "</tr>" +
            "";
    }

    $('#searchUpphoteList').html(html);

});

$('body').on('click', '#addController', function () {
    const saveBox = $('#saveBox');
    const saveModal = new mdb.Modal(saveBox);

    saveModal.show();
});