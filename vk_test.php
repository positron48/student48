<!DOCTYPE html>
<html>
<head>
<title>ЛГТУ|Тестирование api Вконтакте</title>

<? include('parts/head.php'); ?>

<?
	include ("VKapi.php" );

	$api_secret = "QtUffhhGku39y5LxoZNJ"; // со страницы ПЛАТЕЖИ
	$api_id     = "2010617";              // id вашего приложения
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