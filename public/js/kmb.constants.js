var DATATABLES_DEFAULT_SETTING = {
    "pagingType": "bootstrap",
    "processing": true,
    "autoWidth": false,
    "order": [],
    "language": {
        "url": "/js/dataTables.txt"
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
        });
    }
};
