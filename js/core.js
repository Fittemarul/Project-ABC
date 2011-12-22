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
		shade.setAttribute('onclick', 'toggleShade()');
		
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

var validate = {}; // object voor alle validatie functies

//
// Functie voor het valideren van een formulier
//
validate.form = function(formName){
	
	for(i=0; i<= formName.length; i++){
		
		if(formName[i].className == "required"){
			
			var string = formName[i].value;
			
			if(string.replace(" ", "") == ""){
				alert('Gelieve alle velden in te vullen.');
				return false;
			}
			
		}
		
	}
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