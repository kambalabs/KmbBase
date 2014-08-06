$(document).ready(function() {

    var match = document.URL.match(/(\/env\/[0-9]+)/);
    var prefixUri = match ? match[1] : '';

    var refreshExpiredCache = function () {
        $.getJSON(prefixUri + '/refresh-expired-cache');
        setTimeout(refreshExpiredCache, 5000);
    };

    setTimeout(refreshExpiredCache, 5000);
});
