$(window).load(function () {

    var parser = document.createElement('a');
    parser.href = document.URL;
    var prefixUriMatch = parser.pathname.match(/(\/env\/[0-9]+)/);
    var prefixUri = prefixUriMatch ? prefixUriMatch[1] : '';

    $('#current-environment').change(function() {
        var newUrl = '';
        if (prefixUriMatch) {
            var re = new RegExp(prefixUri)
            newUrl += parser.pathname.replace(re, '/env/' + $('#current-environment').val());
        } else {
            newUrl += '/env/' + $('#current-environment').val() + parser.pathname;
        }
        newUrl += parser.search + parser.hash;
        location.href = newUrl;
    });

    $('#groups > tbody').sortable({
        update: function (event, ui) {
            var data = $(this).sortable('serialize');
            $.post(prefixUri + '/puppet/groups/update', data);
        }
    }).disableSelection();


    /* For IE < 9 */
    var propertyChangeUnbound = false;
    $('.editable').on('propertychange', function(e) {
        if (e.originalEvent.propertyName == 'value') {
            $($(this).attr('data-target')).show();
        }
    });
    $('.editable').on('input', function() {
        if (!propertyChangeUnbound) {
            $(this).unbind('propertychange');
            propertyChangeUnbound = true;
        }
        $($(this).attr('data-target')).show();
    });

    $('#actions button[type=reset]').click(function () {
        $('#actions').hide();
    });

    $('.tree li:has(ul)').addClass('parent_li').find(' > span');
    $('.tree li.parent_li > span').on('click', 'i.glyphicon-minus-sign', function (e) {
        $(this).closest('li.parent_li').find(' > ul > li').hide('fast');
        $(this).addClass('glyphicon-plus-sign').removeClass('glyphicon-minus-sign');
        e.stopPropagation();
    });
    $('.tree li.parent_li > span').on('click', 'i.glyphicon-plus-sign', function (e) {
        $(this).closest('li.parent_li').find(' > ul > li').show('fast');
        $(this).addClass('glyphicon-minus-sign').removeClass('glyphicon-plus-sign');
        e.stopPropagation();
    });
    $('.tree li > span').on('click', 'i.glyphicon-zoom-out', function (e) {
        $(this).parent().children('dl.parameters').hide('fast');
        $(this).addClass('glyphicon-zoom-in').removeClass('glyphicon-zoom-out');
        e.stopPropagation();
    });
    $('.tree li > span').on('click', 'i.glyphicon-zoom-in', function (e) {
        $(this).parent().children('dl.parameters').show('fast');
        $(this).addClass('glyphicon-zoom-out').removeClass('glyphicon-zoom-in');
        e.stopPropagation();
    });

    $('#collapse-all').click(function() {
        $('.tree li.parent_li > ul > li').hide('fast');
        $('.tree li.parent_li > span > i.glyphicon-minus-sign').addClass('glyphicon-plus-sign').removeClass('glyphicon-minus-sign');
        $('.tree ul > li > span > dl.parameters').hide('fast');
        $('.tree li > span > i.glyphicon-zoom-out').addClass('glyphicon-zoom-in').removeClass('glyphicon-zoom-out');
        $('#collapse-all').hide();
        $('#expand-all').show();
    });

    $('#expand-all').click(function() {
        $('.tree li.parent_li > ul > li').show('fast');
        $('.tree li.parent_li > span > i.glyphicon-plus-sign').addClass('glyphicon-minus-sign').removeClass('glyphicon-plus-sign');
        $('.tree ul > li > span > dl.parameters').show('fast');
        $('.tree li > span > i.glyphicon-zoom-in').addClass('glyphicon-zoom-out').removeClass('glyphicon-zoom-in');
        $('#expand-all').hide();
        $('#collapse-all').show();
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
        "ajax": {
            "url": window.location,
            "data": function (data) {
                data.factName = $('#fact').val();
                data.factValue = $('#value').val();
            }
        },
        "order": [
            [ 1, "asc" ]
        ],
        "aoColumns": [
            { "bSortable": false },
            { "orderSequence": [ "asc", "desc" ] },
            { "bSortable": false },
            { "bSortable": false },
            { "bSortable": false },
            { "bSortable": false },
            { "bSortable": false },
            { "bSortable": false },
            { "bSortable": false },
            null
        ]
    }));

    $('#select-all-nodes').click(function() {
       $('#servers input.select-node').prop('checked', $(this).prop('checked'));
    });

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
        "ajax": window.location
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

    var updateEnvironment = $('#update-environment');
    updateEnvironment.on('show.bs.modal', function(e) {
        $(this).find('form').attr('action', $(e.relatedTarget).data('href'));
        $('#update-environment-name').val($(e.relatedTarget).attr('data-name'));
        $('#current-environment-name').html($(e.relatedTarget).attr('data-full-name'));
        $('#update-environment-default').prop('checked', $(e.relatedTarget).attr('data-default') == 1);
        var parentSelect = $('#update-parent-select');
        parentSelect.val($(e.relatedTarget).attr('data-parent-id'));
        parentSelect.trigger('chosen:updated');
    });

    var environmentUsers = $('#environment-users').DataTable($.extend({}, dataTablesDefaultSettings, {
        "lengthChange": false,
        "displayLength": 5
    }));

    function refreshUserSelect(id) {
        $.ajax({
            url: prefixUri + "/puppet/environment/" + id + "/available-users",
            dataType: "json"
        }).done(function (data) {
            $('#environment-user-select').html('');
            $(data.users).each(function () {
                $('#environment-user-select').append('<option value="' + this.id + '">' + this.name + ' - ' + this.login + '</option>');
            });
            $("#environment-user-select").trigger("chosen:updated");
        });
    }

    var manageEnvironmentUsers = $('#manage-environment-users');
    manageEnvironmentUsers.on('show.bs.modal', function(e) {
        $(this).find('form').attr('action', $(e.relatedTarget).data('href'));
        $('#current-environment-name').html($(e.relatedTarget).attr('data-full-name'));
        var id = $(e.relatedTarget).attr('data-id');

        $('#add-users').attr('data-environment-id', id);
        environmentUsers.ajax.url(prefixUri + '/puppet/environment/' + id + '/users').load();
        refreshUserSelect(id);
    });

    $('#add-users').click(function() {
        var id = $(this).attr('data-environment-id');
        var users = [];
        $("#environment-user-select option:selected").each(function () {
            users.push($(this).attr('value'));
        });
        $.ajax({
            type: "POST",
            url: prefixUri + "/puppet/environment/" + id + "/add-users",
            data: {'users': users}
        }).done(function() {
            environmentUsers.ajax.reload();
            refreshUserSelect(id);
        });
        return false;
    });

    manageEnvironmentUsers.on('click', '.remove-user', function() {
        var id = $(this).attr('data-environment-id');
        $.ajax({
            url: prefixUri + "/puppet/environment/" + id + "/user/" + $(this).attr('data-user-id') + "/remove"
        }).done(function() {
            environmentUsers.ajax.reload();
            refreshUserSelect(id);
        });
        return false;
    });

    $('#create-environment').on('show.bs.modal', function(e) {
        var parentSelect = $('#create-parent-select');
        parentSelect.val($(e.relatedTarget).attr('data-parent-id'));
        parentSelect.trigger('chosen:updated');
    });

    var groupServers = $('#group-servers');
    groupServers.on('show.bs.modal', function(e) {
        $('#servers-filter').val('');
        var servers = $(this).find('.list-group');
        servers.empty();
        var url = $(e.relatedTarget).data('href');
        if ($(e.relatedTarget).data('current')) {
            url = url + '?include=' + $('#group-include-pattern').val() + '&exclude=' + $('#group-exclude-pattern').val();
        }
        $.getJSON(url, function (data) {
            $('#modal-servers-count').html(data.servers.length);
            for (var index in data.servers) {
                servers.append('<a href="#" class="list-group-item">' + data.servers[index] + '</a>');
            }
        });
    });

    $('#servers-filter').keyup(function () {
        var rex = new RegExp($(this).val(), 'i');
        var item = $('.list-group-item');
        item.hide();
        item.filter(function () {
            return rex.test($(this).text());
        }).show();
    })
});
