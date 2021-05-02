<script src="{{asset('js/jquery.loadBar.min.js')}}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // main color
    loadBar.mainColor = 'red';
    // strip color
    loadBar.stripColor = 'black';
    // animation speed
    loadBar.barSpeed = 5; 
    // bar height
    loadBar.barHeight = 5;

	var page = 1;
	$(document).on('click', '#load-more', function() {
        page++;
        loadMoreData(page, {{$product->id}});
	});

	function loadMoreData(page, product_id){
	  $.ajax({
            url: APP_URL + '/ajax/reviews-approved/product/' + product_id + '?page=' + page,
            type: "get",
            beforeSend: function()
            {
                loadBar.trigger('show');
            }
        })
        .done(function(data) {
            if(data.html == ""){
                $("#load-more").hide();
                loadBar.trigger('hide');
                return;
            }
            $("#approved_reviews").append(data.html);
            loadBar.trigger('hide');
        })
        .fail(function(jqXHR, ajaxOptions, thrownError) {
              alert('server not responding...');
              loadBar.trigger('hide');
        });
	}
</script>