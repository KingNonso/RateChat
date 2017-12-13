//Datepicker
$(function() {
    $( "#datepicker" ).datepicker();
    $( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
});

//Timepicker
$(".timepicker").timepicker({
    showInputs: false
});

//autoload modal
$(window).load(function(){
    $('#myModal').modal('show');
    });
