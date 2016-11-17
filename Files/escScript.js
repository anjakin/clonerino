document.onkeydown = function(event) {
    
    event = event || window.event;
    var isEscape = false;
    if ("key" in event) {
        
        isEscape = (event.key == "Escape" || event.key == "Esc");
    } 
    else {
        
        isEscape = (event.keyCode == 27);
    }
    
    if (isEscape) {
        
        modal.style.display = "none";
    }
}
