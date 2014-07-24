$(document).ready(function() {

    function notifyForCacheRefresh() {
        $.gritter.add({
            title: "Mise à jour des données",
            text: "Les données de l'inventaire PuppetDB ont été mises à jour.",
            class_name: "gritter-light"
        });
    }

    var previous_refreshed_at = new Date().getTime();
    var refreshCacheIfNecessary = function () {
        $.getJSON('/cache', function (data) {
            var fiveMinutes = 5 * 60 * 1000;
            var now = new Date().getTime();
            var refreshed_at = new Date(data.refreshed_at).getTime();
            if (refreshed_at > previous_refreshed_at) {
                previous_refreshed_at = refreshed_at;
                notifyForCacheRefresh();
            }
            if (data.status == null || (data.status == 'completed' && (now - refreshed_at) > fiveMinutes)) {
                $.getJSON('/cache/refresh');
            }
        });
        setTimeout(refreshCacheIfNecessary, 5000);
    };

    setTimeout(refreshCacheIfNecessary, 5000);
});