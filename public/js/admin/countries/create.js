$(document).ready(function(){
    $("#flag").keyup(function(){
        let src1=$("#flag").val();
        $('#img_flag').attr("src", src1)
    });

});
