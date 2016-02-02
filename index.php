<?php
	
/*
	if (isset($_GET['de']) AND isset($_GET['ate'])){
		header('content-type: application/json; charset=utf-8');
		header("access-control-allow-origin: *");

		$de  = $_GET['de'];
		$ate = $_GET['ate'];
		$url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $de . "&destinations=" . $ate . "&language=pt-BR&key=AIzaSyDLgXm5Wq5RhpGB18kBkZTcRt5ew0Np0zM";
		
		$result = file_get_contents($url);
		
		echo $result;
		
		exit;
	}
*/
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Google Distance API</title>
	</head>
<body>
<form action="" method="post" name="theform" id="theform">
    <label>De: </label>
    <input type="text" name="PickupLocation" placeholder="De" id="de" autocomplete="off" />

    <label>Até: </label>
    <input type="text" name="DropoffLocation" placeholder="até" id="ate" autocomplete="off" />
    
    <input type="button" value="Calcular distancia" id="calcular" />
</form>

<div id="distance" style="margin-top: 25px;"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true&libraries=places"></script>
<script type="text/javascript">
	$(document).ready(function(){
		autocomplete = new google.maps.places.Autocomplete(document.getElementById('de'), { types: [ 'geocode' ] });
	    google.maps.event.addListener(autocomplete, 'place_changed', function() {
	      fillInAddress();
	    });
	
	    autocomplete2 = new google.maps.places.Autocomplete(document.getElementById('ate'), { types: [ 'geocode' ] });
	    google.maps.event.addListener(autocomplete2, 'place_changed', function() {
	      fillInAddress();
	    });
	})
	
	$('body').on('click', '#calcular', function(){
		var de  = $('#de').val().replace(' - ', '+').replace(', ', '+');
		var ate = $('#ate').val().replace(' - ', '+').replace(', ', '+');
		//var url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=Carapicu%C3%ADba+SP+Brasil&destinations=Ourinhos+SP+Brasil&language=pt-BR&key=AIzaSyDLgXm5Wq5RhpGB18kBkZTcRt5ew0Np0zM&sensor=false";
		var url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" + removeAcento(de) + "&destinations=" + removeAcento(ate) + "&language=pt-BR&key=AIzaSyDLgXm5Wq5RhpGB18kBkZTcRt5ew0Np0zM&sensor=false";
		//var url = "index.php?de=" + de + "&ate=" + ate;

		$.ajax({
			url: url,
		  	dataType: "json",
		  	success: function (data) {
		    	//console.log(data)
				distance = data.rows[0].elements[0].distance.text;
				
				$('#distance').html('Distância aproximada de: ' + distance);
		  	}
		})
	})
  	function fillInAddress() {
    	var place = autocomplete.getPlace();
    	for (var component in component_form) {
      		document.getElementById(component).value = "";
      		document.getElementById(component).disabled = false;
    	}
    	for (var j = 0; j < place.address_components.length; j++) {
      		var att = place.address_components[j].types[0];
      		if (component_form[att]) {
        		var val = place.address_components[j][component_form[att]];
        		document.getElementById(att).value = val;
      		}
    	}
  	}



	function removeAcento(strToReplace) {
		str_acento = "áàãâäéèêëíìîïóòõôöúùûüçÁÀÃÂÄÉÈÊËÍÌÎÏÓÒÕÖÔÚÙÛÜÇ";
		str_sem_acento = "aaaaaeeeeiiiiooooouuuucAAAAAEEEEIIIIOOOOOUUUUC";
		var nova = "";
		for (var i = 0; i < strToReplace.length; i++) {
			if (str_acento.indexOf(strToReplace.charAt(i)) != -1) {
				nova += str_sem_acento.substr(str_acento.search(strToReplace.substr(i, 1)), 1);
			} else {
				nova += strToReplace.substr(i, 1);
			}
		}
		
		return nova;
	}
</script>

</body>
</html>
