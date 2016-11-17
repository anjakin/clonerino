function validate() {
    
    var screenname = document.getElementById("scrnnm");
    var regex = new RegExp("^[a-zA-Z0-9_-]{5,15}$");
    
    if (!regex.test(screenname.value)) {
        
        if (screenname.value != "") {
            
            screenname.setCustomValidity("Screenname must contain at least 5 letters/numbers.")
        }
        screenname.style.border = "1px solid red";
        return false;
    }
    
    screenname.setCustomValidity("");
    screenname.style.border="1px solid green";
    
    var comment = document.getElementById("cmnttxt");
    if (comment.value == "") {
        
        comment.setCustomValidity("Please type something.");
        return false;
    }
    
    // no error no problem, so we can submit the form or whatever
    comment.setCustomValidity("");
    
    return true;
}
