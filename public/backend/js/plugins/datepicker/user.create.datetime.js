$(function () {
    $('#nominee_dob').datetimepicker({
        pickTime: false
    });
    $('#dd_date').datetimepicker({
        pickTime: false
    });
    $('#dd_drawn_date').datetimepicker({
        pickTime: false
    });
});

$(document).ready(function() {
    $('#date_of_birth').datetimepicker({
        pickTime: false
    });
});
//$(function(){
//    $('#date_of_birth').on('dp.change dp.show', function(e) {
//            $('#userWizard').bootstrapValidator('revalidateField', 'date_of_birth');
        //});
//});