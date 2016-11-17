function ajaxSwitch(newContent) {
    
    var ajax = new XMLHttpRequest();

    ajax.onreadystatechange = function() {

        if (ajax.readyState == 4 && ajax.status == 200)
            document.getElementById("innercontent").innerHTML = ajax.responseText;

        if (ajax.readyState == 4 && ajax.status == 404)
            document.getElementById("innercontent").innerHTML = "Greska: nepoznat URL";
    }

    ajax.open("GET", newContent, true);
    ajax.send();
}
