$(document).ready(function () {

    $('.tree li:has(ul)').addClass('parent_li').find(' > span');
    $('.tree li.parent_li > span > i').on('click', function (e) {
        var children = $(this).closest('li.parent_li').find(' > ul > li');
        if (children.is(":visible")) {
            children.hide('fast');
            $(this).addClass('glyphicon-plus-sign').removeClass('glyphicon-minus-sign');
        } else {
            children.show('fast');
            $(this).addClass('glyphicon-minus-sign').removeClass('glyphicon-plus-sign');
        }
        e.stopPropagation();
    });

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
    $('.chosen-drop').css({minWidth: '100%', width: 'auto'});

    $('.modal.confirm').on('show.bs.modal', function(e) {
        $(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));
        $('.confirm-param1').html($(e.relatedTarget).attr('data-confirm-param1'));
        $('.confirm-param2').html($(e.relatedTarget).attr('data-confirm-param2'));
    });

    var environmentUsers = $('#update-environment-users').DataTable($.extend({}, dataTablesDefaultSettings, {
        "ajax": '/puppet/environments/1/users',
        "lengthChange": false,
        "displayLength": 5
    }));

    $('#update-environment').on('show.bs.modal', function(e) {
        $(this).find('form').attr('action', $(e.relatedTarget).data('href'));
        $('#update-environment-name').val($(e.relatedTarget).attr('data-name'));
        var parentSelect = $('#update-parent-select');
        parentSelect.val($(e.relatedTarget).attr('data-parent-id'));
        parentSelect.trigger('chosen:updated');

        var id = $(e.relatedTarget).attr('data-id');
        environmentUsers.ajax.url('/puppet/environments/' + id + '/users').load();
//        $environmentUsers.fnDraw();

        $.ajax({
            url: "/puppet/environments/" + id + "/available-users",
            dataType: "json"
        }).done(function(data) {
            $('#update-environment-user-select').html('');
            $(data.users).each(function(){
                $('#update-environment-user-select').append('<option value="' + this.id + '">' + this.name + ' - ' + this.login + '</option>');
            });
            $("#update-environment-user-select").trigger("chosen:updated");
        });
    });

    $('#create-environment').on('show.bs.modal', function(e) {
        var parentSelect = $('#create-parent-select');
        parentSelect.val($(e.relatedTarget).attr('data-parent-id'));
        parentSelect.trigger('chosen:updated');
    });
});
