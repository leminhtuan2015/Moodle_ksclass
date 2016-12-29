function initDatePicker(id) {
    var dateTimeFormat = "YYYY/MM/DD"
    $(id).datetimepicker({
        format : dateTimeFormat
    }).on('dp.change',function(event){
        validateDate();
    });
};


initDatePicker("#startDate");
initDatePicker("#endDate");

function validateDate(){
    var startDate = $('#startDate').val()
    var endDate = $('#endDate').val()

    if(!startDate){
        startDate = 0
    }

    if(!endDate){
        endDate = 0
    }

    var startDate1 = new Date(startDate);
    var endDate1 = new Date(endDate);
    var valid = startDate1 <= endDate1

    if(!valid){
        $('#error_date').text("Please makesure end date is more than start date")
    } else {
        $('#error_date').text("")
    }

    return valid
}

$(document).ready(function () {

    $('#createCourseForm').validate({
        rules: {
            name: {
                minlength: 2,
                required: true
            }
        },

        messages: {
            name: "Please specify your name"
        },

        highlight: function (element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function (element) {
            element.text('OK').addClass('has-success')
                .closest('.form-group')
                .removeClass('error')
                .addClass('has-success');
        },

        submitHandler: function(form) {
            if(validateDate()){
                form.submit();
            }
        }
    });

});