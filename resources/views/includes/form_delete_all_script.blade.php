<script>
    $(document).ready(function() {
        $('#options').click(function() {
            if(this.checked) {
                $('.checkboxes').each(function() {
                    this.checked = true;
                })
            } else {
                $('.checkboxes').each(function() {
                    this.checked = false;
                })
            }
        });
    });
</script>