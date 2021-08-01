import { fetchAPI } from './fetchAPI.js';
import { errorBox, errorModal } from './errorBox';
import './inputmask';

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
            "<button type=\"button\" id=\"addController\" data-serial=\"" + item.sn.toUpperCase() + "\" data-ip=\"" + item.ip + "\" class=\"btn btn-success btn-sm px-3\">" +
            "<i class=\"fas fa-plus\"></i>" +
            "</button>" +
            "</td>" +
            "</tr>" +
            "";
    }

    $('#searchUpphoteList').html(html);

});

$('body').on('click', '#addController', function (item) {
    const saveBox = $('#saveBox');
    const saveModal = new mdb.Modal(saveBox);

    const form = $('#saveController');
    const ipv4_address = $('#controlleripv4');

    var serial = $(item.target).data('serial');
    var ip = $(item.target).data('ip');

    saveBox.find('#controllerserial').val(serial);
    saveBox.find('#controlleripv4').val(ip);
    // saveBox.find('#controlleripv4').val(ip);

    ipv4_address.inputmask({
        alias: "ip",
        greedy: false,
        showMaskOnHover: false
    });

    $('#saveController').submit(async function (event) {
        event.preventDefault();

        if (!$('#saveController')[0].checkValidity()) {
            $('#saveController').addClass('was-validated');
            return;
        }

        var bodyParameters = {
            route: {
                path: 'Uhppote',
                module: 'Search'
            }
        }

        try {
            await fetchAPI(bodyParameters);
        } catch ($e) {
            $('#errorBox .bodytext').html($e);
            errorModal.show();
            return;
        }

    });

    saveModal.show();
});