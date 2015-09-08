<!DOCTYPE html>
<html>
<head>
<title>ЛГТУ|Контакты</title>
<? include('parts/head.php'); ?>
</head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<style type="text/css">
  #map_canvas { height: 100% }
</style>
<script type="text/javascript"
    src="http://maps.google.com/maps/api/js?sensor=true">
</script>
<script type="text/javascript">
  function initialize() {
    var latlng = new google.maps.LatLng(52.602044, 39.504733);
    var myOptions = {
      zoom: 15,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.HYBRID 
    };
    var map = new google.maps.Map(document.getElementById("map_canvas"),
        myOptions);
	var marker = new google.maps.Marker({
      position: latlng,
      title:"Административный корпус ЛГТУ!"
  	});
	marker.setMap(map);
  }

</script>
</head>
<body onload="initialize()">

	<? include("parts/top.php"); ?>
    <? include('parts/header.php'); ?>
    <div class="container">
                 	<h1>Контакты:</h1><br />
                    <p>По всем вопросам обращайтесь: <a href="mailto:positron48@gmail.com">positron48@gmail.com</a>
                    <p>Пишите письма, задавайте вопросы, по возможности отвечу.</p>
                    <p><b>Адрес университета: ул.Московская, д.30 </b></p>
					<div id="map_canvas" style="width:690px; height:300px;" align="center"></div>
					<p>Также вы можете посмотреть <a href="/map.php">схему университета</a></p>
    		<? include('parts/footer.php'); ?>    
	</div>
    </center>

</body>
</html>