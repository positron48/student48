<?
	include('parts/settings.php');
	$id=$_GET['id'];
	if(isset($_GET['id']) && $check)
	{
		$query="DELETE FROM materials WHERE id='$id'";
		$del=true;
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>ЛГТУ|Удаление материала</title>
<? include('parts/head.php'); ?>
</head>
<body>

 
	<? include("parts/top.php"); ?>
    <? include('parts/header.php'); ?>
    <div class="container">
	<?
    	if($check && $del)
		{
			$result=mysql_query($query);
			if($result)
				echo("<p class='alert alert-success'>Материал успешно удален</p>");
			else
				echo("<p class='alert alert-error'>Ошибка удаления</p>");		
		}
		else
		{
			printf("<p class='alert alert-danger'>У вас недостаточно прав для удаления материала</p>");	
		}
	?>
    <? include('parts/footer.php'); ?>

</div>

</body>
</html>