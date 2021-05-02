! function(i) {
    "use strict";
    var n = {
        main_fun: function() {
            i("#main-menu").metisMenu(), i(window).bind("load resize", function() {
                i(this).width() < 768 ? i("div.sidebar-collapse").addClass("collapse") : i("div.sidebar-collapse").removeClass("collapse")
            })
        },
        initialization: function() {
            n.main_fun()
        }
    };
    i(document).ready(function() {
        n.main_fun()
    })
}(jQuery);