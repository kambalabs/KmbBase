var DATATABLES_DEFAULT_SETTINGS = {
    "pagingType": "bootstrap",
    "processing": true,
    "autoWidth": false,
    "order": [],
    "language": {
        "url": "/js/dataTables.json"
    }
};

var DATATABLES_NPROGRESS_DEFAULT_SETTINGS = $.extend({}, DATATABLES_DEFAULT_SETTINGS, {
    "fnPreDrawCallback": function() {
        // gather info to compose a message
        NProgress.start();
        return true;
    },
    "drawCallback": function () {
        $('a', this.fnGetNodes()).each(function () {
            $(this).tooltip({
                "placement": $(this).attr('data-placement'),
                delay: {
                    show: 400,
                    hide: 200
                }
            });
            NProgress.done();
        });
    }
});
