$(window).load(function () {

    var parser = document.createElement('a');
    parser.href = document.URL;
    var prefixUriMatch = parser.pathname.match(/(\/env\/[0-9]+)/);
    var prefixUri = prefixUriMatch ? prefixUriMatch[1] : '';

    $('#current-environment').change(function () {
        var newUrl = '';
        if (prefixUri) {
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
    $('.editable').on('propertychange', function (e) {
        if (e.originalEvent.propertyName == 'value') {
            $($(this).attr('data-target')).show();
        }
    });
    $('.editable').on('input', function () {
        if (!propertyChangeUnbound) {
            $(this).unbind('propertychange');
            propertyChangeUnbound = true;
        }
        $($(this).attr('data-target')).show();
    });

    $('.inline-editable > .inline-editable-clickable').click(function () {
        var parent = $(this).parent();
        parent.hide();
        var form = parent.siblings('.form-inline-editable');
        form.show();
        form.find('> .input-group > .form-control').focus();
    });

    $('.form-inline-editable button[type=reset]').click(function () {
        var parent = $(this).closest('.form-inline-editable');
        parent.hide();
        parent.siblings('.inline-editable').show();
    });

    $('.form-inline-editable > .input-group > .form-control').keyup(function (evt) {
        if (evt.keyCode == 27) {
            $(this).closest('.form-inline-editable').find('button[type=reset]').click();
            $(this).blur();
        }
    });

    $('#actions button[type=reset]').click(function () {
        $('#actions').hide();
    });

    $('.tree li:has(ul)').addClass('parent_li');
    $('.tree li.parent_li .tree-item > a').on('click', 'i.glyphicon-minus-sign', function (e) {
        var element = $(this).closest('li.parent_li').find('> ul > .tree-level');
        if (element.length == 0) {
            element = $(this).closest('li.parent_li').find('> form > ul > .tree-level');
        }
        element.hide('fast');
        $(this).addClass('glyphicon-plus-sign').removeClass('glyphicon-minus-sign');
        e.stopPropagation();
        return false;
    });
    $('.tree li.parent_li .tree-item > a').on('click', 'i.glyphicon-plus-sign', function (e) {
        var element = $(this).closest('li.parent_li').find('> ul > .tree-level');
        if (element.length == 0) {
            element = $(this).closest('li.parent_li').find('> form > ul > .tree-level');
        }
        element.show('fast');
        $(this).addClass('glyphicon-minus-sign').removeClass('glyphicon-plus-sign');
        e.stopPropagation();
        return false;
    });
    $('.tree li .tree-item > a').on('click', 'i.glyphicon-zoom-out', function (e) {
        $(this).parent().siblings('.see-more').hide('fast');
        $(this).addClass('glyphicon-zoom-in').removeClass('glyphicon-zoom-out');
        e.stopPropagation();
        return false;
    });
    $('.tree li .tree-item > a').on('click', 'i.glyphicon-zoom-in', function (e) {
        $(this).parent().siblings('.see-more').show('fast');
        $(this).addClass('glyphicon-zoom-out').removeClass('glyphicon-zoom-in');
        e.stopPropagation();
        return false;
    });
    $('.tree li.parent_li .tree-item > a').on('click', 'i.glyphicon-plus.create-element', function (e) {
        var newElement = $(this).closest('li.parent_li').find('> ul > .new-element');
        if (newElement.length == 0) {
            newElement = $(this).closest('li.parent_li').find('> form > ul > .new-element');
        }
        newElement.show('fast');
        var formControl = newElement.find('.form-control');
        formControl.prop('disabled', false);
        formControl.focus();
        e.stopPropagation();
        return false;
    });
    $('.values-form').on('reset', function() {
        $(this).find('.new-element .form-control').prop('disabled', true);
    })

    $('.collapse-all').click(function () {
        var tree = $(this).closest('.tree');
        tree.find('li.parent_li > ul > .tree-level').hide('fast');
        tree.find('li.parent_li > .tree-item > a > i.glyphicon-minus-sign').addClass('glyphicon-plus-sign').removeClass('glyphicon-minus-sign');
        tree.find('ul > .tree-level > .tree-item > .see-more').hide('fast');
        tree.find('li > .tree-item > a > i.glyphicon-zoom-out').addClass('glyphicon-zoom-in').removeClass('glyphicon-zoom-out');
        $(this).hide();
        $(this).siblings('.expand-all').show();
    });

    $('.expand-all').click(function () {
        var tree = $(this).closest('.tree');
        tree.find('li.parent_li > ul > .tree-level').show('fast');
        tree.find('li.parent_li > .tree-item > a > i.glyphicon-plus-sign').addClass('glyphicon-minus-sign').removeClass('glyphicon-plus-sign');
        tree.find('ul > .tree-level > .tree-item > .see-more').show('fast');
        tree.find('li > .tree-item > a > i.glyphicon-zoom-in').addClass('glyphicon-zoom-out').removeClass('glyphicon-zoom-in');
        $(this).hide();
        $(this).siblings('.collapse-all').show();
    });

    $('.add-parameter').click(function(e) {
        var newElement = $(this).closest('.panel-heading').siblings('.panel-body').children('.tree').find('> ul > .new-element');
        newElement.show('fast');
        var formControl = newElement.find('.form-control');
        formControl.prop('disabled', false);;
        formControl.focus();
        e.stopPropagation();
        return false;
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
            },
            "error": function (cause) {
                console.log('Could not get servers list : ' + cause.statusText);
                $('#servers_processing').hide();
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

    $('#select-all-nodes').click(function () {
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

    $('.modal.confirm').on('show.bs.modal', function (e) {
        $(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));
        $('.confirm-param1').html($(e.relatedTarget).attr('data-confirm-param1'));
        $('.confirm-param2').html($(e.relatedTarget).attr('data-confirm-param2'));
    });

    var confirmRemoveValue = $('#confirm-remove-value');
    confirmRemoveValue.on('show.bs.modal', function (e) {
        var element = $(e.relatedTarget);
        $('.confirm-text').html(element.attr('data-confirm-text'));
        $(this).find('.danger').click(function() {
            var treeLevel = element.closest('.tree-level');
            var form = treeLevel.closest('form.values-form');
            treeLevel.remove();
            form.submit();
        });
    });
    confirmRemoveValue.on('hide.bs.modal', function () {
        $(this).find('.danger').unbind('click');
    });

    $('#update-environment').on('show.bs.modal', function (e) {
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
    manageEnvironmentUsers.on('show.bs.modal', function (e) {
        $(this).find('form').attr('action', $(e.relatedTarget).data('href'));
        $('#current-environment-name').html($(e.relatedTarget).attr('data-full-name'));
        var id = $(e.relatedTarget).attr('data-id');

        $('#add-users').attr('data-environment-id', id);
        environmentUsers.ajax.url(prefixUri + '/puppet/environment/' + id + '/users').load();
        refreshUserSelect(id);
    });

    $('#add-users').click(function () {
        var id = $(this).attr('data-environment-id');
        var users = [];
        $("#environment-user-select option:selected").each(function () {
            users.push($(this).attr('value'));
        });
        $.ajax({
            type: "POST",
            url: prefixUri + "/puppet/environment/" + id + "/add-users",
            data: {'users': users}
        }).done(function () {
            environmentUsers.ajax.reload();
            refreshUserSelect(id);
        });
        return false;
    });

    manageEnvironmentUsers.on('click', '.remove-user', function () {
        var id = $(this).attr('data-environment-id');
        $.ajax({
            url: prefixUri + "/puppet/environment/" + id + "/user/" + $(this).attr('data-user-id') + "/remove"
        }).done(function () {
            environmentUsers.ajax.reload();
            refreshUserSelect(id);
        });
        return false;
    });

    $('#create-environment').on('show.bs.modal', function (e) {
        var parentSelect = $('#create-parent-select');
        parentSelect.val($(e.relatedTarget).attr('data-parent-id'));
        parentSelect.trigger('chosen:updated');
    });

    var groupServers = $('#group-servers');
    groupServers.on('show.bs.modal', function (e) {
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

    $('.class-name').click(function () {
        var activeParameters = $('.class-parameters.active');
        if (activeParameters.length) {
            activeParameters.hide();
            activeParameters.removeClass('active');
        } else {
            $('#group-description').hide();
        }
        var parameters = $('.class-parameters[data-class-id=' + $(this).attr('data-class-id') + ']');
        parameters.show();
        parameters.addClass('active');
        return false;
    });

    $('.class-parameters button.close').click(function () {
        $(this).closest('.class-parameters').removeClass('active').hide();
        $('#group-description').show();
    });
});
