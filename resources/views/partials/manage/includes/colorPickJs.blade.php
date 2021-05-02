<script src="{{asset('js/colorpick/colorPick.js')}}"></script>

<script>
    $(document).ready(function() {
        colorUpdate();
        checkVariantName();
    });
    function colorUpdate() {
        var i = 0;
        var colorPicker =  $(".colorPickSelector");
        var color_elem = colorPicker.length;
        colorPicker.colorPick({
            'palette': ["red", "green", "blue", "orange", "purple", "grey", "black", "white", "pink", "yellow"],
            'onColorSelected': function() {
                if(i > color_elem){
                    this.element[0].value = this.color;
                }
                i++;
            }
        });
    }
    
    function checkColorVariation(variation_id) {
        var color_variation = $('#' + variation_id);
        var is_color = $('#is_color_' + variation_id);
        if(color_variation.prop('checked') === true){
            is_color.val(1);
            addColorPickerVariation(variation_id);
        }else{
            is_color.val(0);
            removeColorPickerVariation(variation_id);
        }
    }

    function checkVariantName(){
        // $('.variant_name').find('input[value="Color"]')[0]
        $('.variant_name_value').on('blur',function (e) {
            // console.log(this);
            if (this.value.toUpperCase() === 'COLOR' || this.value.toUpperCase() === 'COLORS'){
                var inp_elem = $(this).parent().parent().find('td input[type="text"]');
                inp_elem.each(function () {
                    $(this).addClass('colorPickSelector');
                    colorUpdate();
                });
            }else {
                var inp_elem = $(this).parent().parent().find('td input[type="text"]');
                inp_elem.each(function () {
                    if(this.classList.contains('colorPickSelector')){
                        $(this).removeClass('colorPickSelector');
                        var tbody = $(this).parent().parent().parent();
                        if(tbody.find('tr').length > 2) {
                            $(this).parent().parent().remove();
                        }else{
                            var row = tbody.find('tr:nth-child(1)').clone().find("input:text").val("").end().find("input[type='number']").val("").end();
                            tbody.find('tr:last').prev().after(row);
                            $(this).parent().parent().remove();
                            colorUpdate();
                        }
                    }
                    colorUpdate();
                });
            }
        });
    }

    function addColorPickerVariation(variation_id){
        var elem = $('#' + variation_id);
        var inp_elem = elem.parent().parent().parent().parent().find('td input[type="text"]');
        inp_elem.each(function () {
            $(this).addClass('colorPickSelector');
            colorUpdate();
        });
    }

    function removeColorPickerVariation(variation_id) {
        var elem = $('#' + variation_id);
        var inp_elem = elem.parent().parent().parent().parent().find('td input[type="text"]');
        inp_elem.each(function () {
            if(this.classList.contains('colorPickSelector')){
                $(this).removeClass('colorPickSelector');
                var tbody = $(this).parent().parent().parent();
                if(tbody.find('tr').length > 2) {
                    $(this).parent().parent().remove();
                }else{
                    var row = tbody.find('tr:nth-child(1)').clone().find("input:text").val("").end().find("input[type='number']").val("").end();
                    tbody.find('tr:last').prev().after(row);
                    $(this).parent().parent().remove();
                    colorUpdate();
                }
            }
            colorUpdate();
        });
    }

</script>