<script>
    $(document).ready(function(){
        var role_tab = $('input[type=radio][name=user_role]');
        var lastUrlSegment = location.href.substring(location.href.lastIndexOf('/') + 1);
        role_tab.on('change', function(e) {
            localStorage.setItem(lastUrlSegment+'_activeRole', this.value);
        });
        var activeRole = localStorage.getItem(lastUrlSegment+'_activeRole');
        if(activeRole){
            if(activeRole == 'seller'){
                role_tab.trigger("change");
                role_tab[1].checked = true;
            }else {
                role_tab[0].checked = true;
            }
        }
    });
</script>