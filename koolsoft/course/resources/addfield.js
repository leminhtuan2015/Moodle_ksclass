var wrapper = $("#lectures")
var add_button = $("#addLectureButton")
var index = 1

$(add_button).click(function(e){
    e.preventDefault()
    index++

    var newElement =
        "<div class=\"panel panel-success\"> " +
        "<div class=\"panel-heading\">" +
        "<a data-toggle='collapse' data-target='#courseDetail" + index + "'" + " href=\"#courseDetail\">Lecture</a>" +
        "<button class='btn btn-danger pull-right btn-xs remove_field' >Remove</button>" +
        "</div> " +
        "<div id='courseDetail" + index + "'" + " class='panel-collapse collapse in'>" +
        "<div class=\"form-group\"> " +
        "<label for=\"inputName\" class=\"control-label\" >Lecture Name</label> " +
        "<input form='createCourseForm' type='text' name='lectures" + "[" + index + "]" + "[name]' class='form-control' placeholder='Lecture Name'> " +
        "</div> " +
        "<div class=\"form-group\"> " +
        "<label for=\"inputName\" class=\"control-label\" >Lecture Content</label> " +
        "<input form='createCourseForm' type='text' name='lectures" + "[" + index + "]" + "[content]' class='form-control' placeholder='Lecture Content'> " +
        "</div> " +
        "</div>" +
        "</div>";

//            $(wrapper).append('<div><input type="text" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div>')
    $(wrapper).append(newElement)
});

$(wrapper).on("click",".remove_field", function(e){
    e.preventDefault(); $(this).parent('div').parent('div').remove()
    index--
})
