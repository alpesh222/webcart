(function($) { 
"use strict"; 
function rtcScript() {
    document.oncontextmenu = null;
    document.onselectstart = null;
    document.onmousedown = null;
    document.onclick = null;
    document.oncopy = null;
    document.oncut = null;
    var elements = document.getElementsByTagName('*');
    for (var i = 0; i < elements.length; i++) {
        elements[i].oncontextmenu = null;
        elements[i].onselectstart = null;
        elements[i].onmousedown = null;
        elements[i].oncopy = null;
        elements[i].oncut = null;
    }

    function preventShareThis() {
        document.getSelection = window.getSelection = function() {
            return {
                isCollapsed: true
            };
        }
    }
    var scripts = document.getElementsByTagName('script');
    for (var i = 0; i < scripts.length; i++) {
        if (scripts[i].src.indexOf('w.sharethis.com') > -1) {
            preventShareThis();
        }
    }
    if (typeof Tynt != 'undefined') {
        Tynt = null;
    }
}
rtcScript();
setInterval(rtcScript, 2000);
})(jQuery);