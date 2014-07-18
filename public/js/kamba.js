$(document).ready(function () {
    var dataTablesDefaultSettings = {
        "sPaginationType": "bootstrap",
        "bProcessing": true,
        "bAutoWidth": false,
        "aaSorting": [],
        "oLanguage": {
            "sUrl": "/js/dataTables.french.txt"
        },
        "fnDrawCallback": function () {
            $('a', this.fnGetNodes()).each(function () {
                $(this).tooltip({
                    "placement": $(this).attr('data-placement'),
                    delay: {
                        show: 400,
                        hide: 200
                    }
                });
            });
        }
    };

    var serversTable = $('#servers').dataTable($.extend({}, dataTablesDefaultSettings, {
        "processing": true,
        "serverSide": true,
        "stateSave": true,
        "ajax": {
            "url": "/servers",
            "data": function (data) {
                data.factName = $('#fact').val();
                data.factValue = $('#value').val();
            }
        },
        "order": [
            [ 0, "asc" ]
        ],
        "aoColumns": [
            { "orderSequence": [ "asc", "desc" ] },
            { "bSortable": false },
            { "bSortable": false },
            { "bSortable": false },
            { "bSortable": false },
            { "bSortable": false },
            { "bSortable": false },
            null
        ]
    }));

    $('#fact-filter-submit').click(function () {
        if ($('#fact').val() == 'default') {
            $('#fact').closest('.form-group')
                .addClass('has-error')
                .delay(2000).queue(function () {
                    $(this).removeClass("has-error").dequeue();
                });
            return false;
        }
        serversTable.fnDraw();
        return false;
    });

    $('#fact-filter-reset').click(function () {
        $('#fact').val('').trigger('chosen:updated');
        $('#value').val('');
        serversTable.fnDraw();
        return false;
    });

    $('#facts').dataTable($.extend({}, dataTablesDefaultSettings, {
        "sAjaxSource": document.URL.replace(/(\/show)?(\?.*)?$/gm, '') + '/facts'
    }));

    $('#reports').dataTable($.extend({}, dataTablesDefaultSettings, {
        "processing": true,
        "serverSide": true,
        "stateSave": true,
        "ajax": "/puppet/reports"
    }));

    $('[data-rel=chosen]').chosen({
        search_contains: true
    });
    $('.chosen-container').width('100%');
});