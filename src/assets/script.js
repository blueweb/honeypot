(function () {
    elems = document.body.querySelectorAll('.blueweb-additional_info');

    for (var i = 0; i < elems.length; ++i) {
        var elem = elems[i];
        elem.setAttribute('style', 'display:none !important;')
    }

})();