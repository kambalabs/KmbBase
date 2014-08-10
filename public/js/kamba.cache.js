$(document).ready(function () {
    var match = document.URL.match(/(\/env\/[0-9]+)/);
    var prefixUri = match ? match[1] : '';

    var refreshExpiredCache = function () {
        $.getJSON(prefixUri + '/refresh-expired-cache', function (data) {
            if (data.refresh) {
                $.gritter.add({
                    title: "Mise à jour du cache",
                    text: "Les données en cache ont été mises à jour.",
                    class_name: "gritter-light"
                });
            }
            setTimeout(refreshExpiredCache, 5000);
        });
    };

    setTimeout(refreshExpiredCache, 5000);

    $('#clear-cache').click(function () {
        $.getJSON(prefixUri + '/clear-cache');
    });
});
