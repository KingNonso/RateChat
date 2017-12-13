//Datepicker
$(function() {
    $( "#datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true,
        //yearRange: '1950:2013', // specifying a hard coded year range
        yearRange: '-100:+0', // last hundred years
        maxDate: "+0d" //The maximum selectable date. When set to null, there is no maximum
        //minDate: new Date(2007, 1 - 1, 1)
        //"y" for years, "m" for months, "w" for weeks, and "d" for days. For example, "+1m +7d" represents one month and seven days from today.
    });
    $( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
    $( "#datepicker" ).datepicker( "setDate", "2012-12-12" );
});
