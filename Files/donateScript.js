function validate() {
    
    var email = document.getElementById("email");
    var creditCard = document.getElementById("cnum");
    var emailRegex = new RegExp("^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$");
    var creditCardRegex = new RegExp("^4[0-9]{12}(?:[0-9]{3})?$");
    
    if (!emailRegex.test(email.value)) {
        
        email.style.border = "1px solid red";
        email.setCustomValidity("Invalid email.");
        return false;
    }
    
    email.style.border = "1px solid green";
    email.setCustomValidity("");
    
    if (!creditCardRegex.test(creditCard.value)) {
        
        creditCard.style.border = "1px solid red";
        creditCard.setCustomValidity("Invalid credit card number.");
        return false;
    }
    
    creditCard.style.border = "1px solid green";
    creditCard.setCustomValidity("");
    
    return true;
}
