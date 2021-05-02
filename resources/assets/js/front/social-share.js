(function($) { 
"use strict"; 
jQuery(document).ready(function($) {
    jQuery('a.social-share').on('click', function(){
        newwindow=window.open($(this).attr('href'),'','height=500,width=500');
        if (window.focus) {newwindow.focus()}
        return false;
    });
});
})(jQuery);