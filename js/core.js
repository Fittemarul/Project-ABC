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