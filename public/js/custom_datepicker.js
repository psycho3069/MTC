
$(document).ready(function () {

    var check_in = flatpickr("#check_in_date", {minDate: new Date()});
    var check_out = flatpickr("#check_out_date", {minDate: new Date()});

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