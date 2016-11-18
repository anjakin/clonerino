function modalThing(index) {
    
    var modal = document.getElementById("modalid");
    var img = document.getElementsByClassName("images")[index];
    var modalImg = document.getElementById("img");
    var captionText = document.getElementById("caption");
    
    img.onclick = function() {
        
        modal.style.display = "block";
        modalImg.src = this.src;
        captionText.innerHTML = this.alt;
    }

    var span = document.getElementById("close");

    span.onclick = function() { 
        
        modal.style.display = "none";
    }
    
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
}
