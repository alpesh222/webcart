<script src="{{asset('js/jquery.loadBar.min.js')}}"></script>
<script>
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

    var reviews = $('#reviews');
    var appended = 0;

    $(document).on('click', '.edit-review', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        loadBar.trigger('show');
        $.get(url, function(receivedData) {
            if(appended == 0) {
                if(!receivedData.error) {
                    reviews.append(receivedData);
                    appended++;
                } else {
                    reviews.append('<h1>Something went wrong!</h1>');
                }
            }
            loadBar.trigger('hide');
        });
    });

    $(document).on('submit', '#review-form', function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        var url = $(this).attr('action');

        loadBar.trigger('show');
        $.post(url, data, function(receivedData) {
            if(!receivedData.error) {
                reviews.html(receivedData);
            } else {
                reviews.html('<h1>Something went wrong!</h1>');
            }
            loadBar.trigger('hide');
        });
    });

    $(document).on('submit', '#review-form-update', function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        var url = $(this).attr('action');

        loadBar.trigger('show');
        $.post(url, data, function(receivedData) {
            if(!receivedData.error) {
                reviews.html(receivedData);
                appended--;
            } else {
                reviews.html('<h1>Something went wrong!</h1>');
            }
            loadBar.trigger('hide');
        });
    });

</script>