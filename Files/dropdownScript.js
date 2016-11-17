function openDropdown() {
    
    document.getElementById("dropdownops").classList.toggle("show");
}

window.onclick = function(event) {
    
  if (!event.target.matches('.dropdownbtn')) {

    var dropdownOptions = document.getElementsByClassName("dropdown-options");
    var i;
    for (i = 0; i < dropdownOptions.length; i++) {
        
      var openDropdown = dropdownOptions[i];
      if (openDropdown.classList.contains('show')) {
          
        openDropdown.classList.remove('show');
      }
    }
  }
}
