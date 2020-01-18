
$(document).ready(function () {





    $("#start_date").on('click',function () {
        var a = '';
        var res = [];
        if ($('#start_date').val()) {
            var d = $('#start_date').val();
            var res = d.split("-");
            $('#start_date').val(res[2]+'-'+res[1]+'-'+res[0]);
        }
    });

    $("#end_date").on('click',function () {
        var a = '';
        var res = [];
        if ($('#end_date').val()) {
            var d = $('#end_date').val();
            var res = d.split("-");
            $('#end_date').val(res[2]+'-'+res[1]+'-'+res[0]);
        }
    });

    // var check_in = flatpickr("#start_date", {minDate: new Date()});
    // var check_out = flatpickr("#end_date", {minDate: new Date()});

    var check_in = flatpickr("#start_date");
    var check_out = flatpickr("#end_date");

    check_in.set("onChange", function (d) {
        check_out.set("minDate", d.fp_incr(1)); //increment by one day
    });
    check_out.set("onChange", function (d) {
        check_in.set("maxDate", d);
    });



    var disabledDays = [0, 6];

    $('#disabled-days').datepicker({
        language: 'en',
        onRenderCell: function (date, cellType) {
            if (cellType == 'day') {
                var day = date.getDay(),
                    isDisabled = disabledDays.indexOf(day) != -1;

                return {
                    disabled: isDisabled
                }
            }
        }
    });

});
