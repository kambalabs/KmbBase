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

    var flashMessages = $('ul.flash');
    if (flashMessages.length > 0) {
        flashMessages.children('li').each(function() {
            var h4 = $(this).children('h4');
            var title = null;
            if (h4.length > 0) {
                title = h4.text();
                h4.remove();
            }
            $.gritter.add({
                title: title,
                text: $(this).html(),
                sticky: true,
                class_name: $(this).attr('class')
            });
        });
    }

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
    $('.editable').on('change', function () {
        if (!propertyChangeUnbound) {
            $(this).unbind('propertychange');
            propertyChangeUnbound = true;
        }
        $($(this).attr('data-target')).show();
    });

    $('.editable-actions button[type=reset]').click(function () {
        $(this).closest('.editable-actions').hide();
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
});
