<!DOCTYPE html>
<html>
<head>
<title>����|������������ api ���������</title>

<? include('parts/head.php'); ?>

<?
	include ("VKapi.php" );

	$api_secret = "QtUffhhGku39y5LxoZNJ"; // �� �������� �������
	$api_id     = "2010617";              // id ������ ����������
	$api        = new VKapi($api_secret, $api_id);
?>

</head>
<body>

 
	<? include("parts/top.php"); ?>
    <? include('parts/header.php'); ?>
    <div class="container">
    <?
		print_r($api->getProfiles('14518894'));
	?>
    
    <? include('parts/footer.php'); ?>
    
</div>

</body>
</html>