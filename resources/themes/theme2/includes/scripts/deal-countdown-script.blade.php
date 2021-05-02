<script>
{{--    Javascript Code For Multiple Timer in a single Page Using Javascript Dynamic Variables --}}
    var seconds_inputs =  document.getElementsByClassName('deal_left_seconds');
    var total_timers = seconds_inputs.length;
    for ( var i = 0; i < total_timers; i++){
        var str_seconds = 'seconds_'; var str_seconds_prod_id = 'seconds_prod_id_';
        var seconds_prod_id = seconds_inputs[i].getAttribute('data-value');
        var cal_seconds = seconds_inputs[i].getAttribute('value');

        eval('var ' + str_seconds + seconds_prod_id + '= ' + cal_seconds + ';');
        eval('var ' + str_seconds_prod_id + seconds_prod_id + '= ' + seconds_prod_id + ';');
    }
    function timer() {
        for ( var i = 0; i < total_timers; i++) {
            var seconds_prod_id = seconds_inputs[i].getAttribute('data-value');

            var days = Math.floor(eval('seconds_'+seconds_prod_id) / 24 / 60 / 60);
            var hoursLeft = Math.floor((eval('seconds_'+seconds_prod_id)) - (days * 86400));
            var hours = Math.floor(hoursLeft / 3600);
            var minutesLeft = Math.floor((hoursLeft) - (hours * 3600));
            var minutes = Math.floor(minutesLeft / 60);
            var remainingSeconds = eval('seconds_'+seconds_prod_id) % 60;

            function pad(n) {
                return (n < 10 ? "0" + n : n);
            }
            document.getElementById('deal_days_' + seconds_prod_id).innerHTML = pad(days);
            document.getElementById('deal_hrs_' + seconds_prod_id).innerHTML = pad(hours);
            document.getElementById('deal_min_' + seconds_prod_id).innerHTML = pad(minutes);
            document.getElementById('deal_sec_' + seconds_prod_id).innerHTML = pad(remainingSeconds);

            if (eval('seconds_'+ seconds_prod_id) == 0) {
                clearInterval(countdownTimer);
                document.getElementById('deal_days_' + seconds_prod_id).innerHTML = document.getElementById('deal_hrs_' + seconds_prod_id).innerHTML = document.getElementById('deal_min_' + seconds_prod_id).innerHTML = document.getElementById('deal_sec_' + seconds_prod_id).innerHTML = pad(0);
            } else {
                var value = eval('seconds_'+seconds_prod_id);
                value--;
                eval('seconds_' + seconds_prod_id + '= ' + value + ';');
            }
        }
    }

    var countdownTimer = setInterval('timer()', 1000);

</script>