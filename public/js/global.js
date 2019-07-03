var ajaxResponse = function(response){
    $(".alert-area").removeClass("alert-success");
    $(".alert-area").removeClass("alert-danger");
    if(response.status == 1){
        $(".alert-area").addClass("alert-success");
    }
    else{
        $(".alert-area").addClass("alert-danger");
    }

    $(".alert-area").find(".alert-text").html('<strong>'+response.status_string+'</strong> '+response.message);
    $(".alert-area").show();

    $.unblockUI();

    if(typeof response.data.redirectURL != 'undefined'){
        setTimeout(function(){
            location.href = response.data.redirectURL;
        },3000);
    }

    $('html, body').animate({scrollTop:0},500);
}
