(function($) { 
"use strict";
$(function()
{
     $( "#search-keyword" ).autocomplete({
      source: APP_URL + "/search/autocomplete",
      minLength: 3,
      select: function(event, ui) {
        $('#search-keyword').val(ui.item.value);
      }
    })
     .autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li>" )
        .append( "<div class='autocomplete-item'><a href='" + item.link + "'>" 
                    + "<span class='item'>"
                    +   "<span class='item-left'>"
                    +       "<div class='cart-image'>"
                    +         "<img class='img-responsive' src='" + item.imgsrc + "' alt='" + item.value + "' />"
                    +       "</div>"
                    +    "<span class='item-info'>"
                    +       "<span><strong>" + item.value + "</strong></span>"
                    +    "</span>"
                    +   "</span>"
                    + "</span>" +
                 "</a></div>" )
        .appendTo( ul );
    };

});
})(jQuery);