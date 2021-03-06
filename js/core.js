//
// Namespaces definieren
//
var validate = {}; // object voor alle validatie functies
var bewerk = {}; // object voor alle bewerk functies
var verwerk = {};

//
// Shortcut voor document.getElementById
//
function $(a){
	return document.getElementById(a)
}

//
// functie die de shade toont of verbergt
// afhankelijk van de huidige toestand
//
function toggleShade(){

	// Shade injecteren als deze nog niet bestaat
	if( $('shade') == null ){
		var shade = document.createElement('div');
		shade.setAttribute('id', 'shade');
		shade.setAttribute('onclick', 'window.location.reload(); calendar.hideCalendar();');

		document.body.appendChild(shade); // element in body schrijven
	}

	if( $('shade').style.display == 'block'){
		$('shade').style.display = "none";
		$('overlay').style.display = "none";
	}else{
		$('shade').style.display = "block";
		$('overlay').style.display = "block";
	}
}

//
// Functie voor het valideren van een formulier
//
validate.form = function(formName){

	for(i=0; i<= formName.length -1; i++){

		if(formName[i].className.indexOf("required") != -1){

			var string = formName[i].value;

			if(string.replace(" ", "") == ""){
				alert('Gelieve alle velden in te vullen.');
				return false;
			}

		}

	}

	// Alles is in orde. Formulier mag door, submit deactiveren
	toggleSubmitbtn(formName);
}

//
// Functie die de submit button deactiveerd om meerdere
// kliks te voorkomen.
//
function toggleSubmitbtn(formName){

	for(i=0; i<= formName.length -1; i++){
		if(formName[i].type == "submit"){

			formName[i].value = "Bezig met laden...";
			formName[i].disabled = true;

		}
	}
}

//
// Prototype functie die werkt voor alle arrays. Verwijderd array item met specifieke waarde
// @source		http://stackoverflow.com/questions/3954438/remove-item-from-array-by-value
//
Array.prototype.remove = function(){
    var what, a= arguments, L= a.length, ax;
    while(L && this.length){
        what= a[--L];
        while((ax= this.indexOf(what))!= -1){
            this.splice(ax, 1);
        }
    }
    return this;
}

//
// Removes a li from an UL
// @source		http://stackoverflow.com/questions/4417164/remove-li-directly-by-an-onclick
//
function removeMe(link) {
    link.parentNode.parentNode.removeChild(link.parentNode);
}

//
// This function decodes a URL encoded string
//
function urldecode(str) {
   return decodeURIComponent((str+'').replace(/\+/g, '%20'));
}