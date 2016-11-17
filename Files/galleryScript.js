var modal = document.getElementById("modalpic");

var img = document.getElementById("firstimage");
var modalImg = document.getElementById("img1");
var captionText = document.getElementById("caption");
img.onclick = function() {
    
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
}

var span = document.getElementsByClassName("close")[0];

span.onclick = function() { 
    
  modal.style.display = "none";
}
