setInterval(() => {

if($(".success-message").length > 0){
    $(".success-message").fadeOut(500);

}

if($(".error-message").length > 0){
    $(".error-message").fadeOut(500);
    
}


}, 3000);