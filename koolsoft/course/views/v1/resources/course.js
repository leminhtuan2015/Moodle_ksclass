/**
 * Created by leminhtuan on 1/9/17.
 */

function addInput(id, placeholder){
    var newdiv = document.createElement('div');
    newdiv.innerHTML = "<br><input type='text' placeholder=' " + placeholder + "' name='name[]'><a href='#' class='remove_field'> Remove</a>";
    document.getElementById(id).appendChild(newdiv);

    $("#"+id).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault()
        $(this).parent('div').remove()
    })
}