<script>
    $(document).ready(function(){
        var lastUrlSegment = location.href.substring(location.href.lastIndexOf('/') + 1);
        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem(lastUrlSegment+'_activeTab', $(e.target).attr('href'));
            $('#alert_success').css('display','none');
            $('#alert_error').css('display','none');
        });
        var activeTab = localStorage.getItem(lastUrlSegment+'_activeTab');
        if(activeTab){
            $('#'+lastUrlSegment+'-nav-tabs a[href="' + activeTab + '"]').tab('show');
            $('#alert_success').css('display','block');
            $('#alert_error').css('display','block');
        }
    });
</script>