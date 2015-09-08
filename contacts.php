<!DOCTYPE html>
<html>
<head>
<title>����|��������</title>
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
      title:"���������������� ������ ����!"
  	});
	marker.setMap(map);
  }

</script>
</head>
<body onload="initialize()">

	<? include("parts/top.php"); ?>
    <? include('parts/header.php'); ?>
    <div class="container">
                 	<h1>��������:</h1><br />
                    <p>�� ���� �������� �����������: <a href="mailto:positron48@gmail.com">positron48@gmail.com</a>
                    <p>������ ������, ��������� �������, �� ����������� ������.</p>
                    <p><b>����� ������������: ��.����������, �.30 </b></p>
					<div id="map_canvas" style="width:690px; height:300px;" align="center"></div>
					<p>����� �� ������ ���������� <a href="/map.php">����� ������������</a></p>
    		<? include('parts/footer.php'); ?>    
	</div>
    </center>

</body>
</html>