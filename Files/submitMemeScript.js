function validate() {
    
    var screenname = document.getElementById("scrnnm");
    var title = document.getElementById("title");
    var nameRegex = new RegExp("^[a-zA-Z0-9_-]{5,15}$");
    var titleRegex = new RegExp(".{1,20}");
    
    if (!nameRegex.test(screenname.value)) {
        
        if (screenname.value != "") {
            
            screenname.setCustomValidity("Screenname must contain at least 5 letters/numbers.")
        }
        
        screenname.style.border = "1px solid red";
        return false;
    }
    
    screenname.setCustomValidity("");
    screenname.style.border="1px solid green";
    
    if (!titleRegex.test(title.value)) {
        
        if (title.value != "") {
            
            title.setCustomValidity("Title can't be longer than 20 characters.")
        }
        
        title.style.border = "1px solid red";
        return false;
    }
    
    title.setCustomValidity("");
    title.style.border="1px solid green";
    
    return true;
}