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
<title>����|�������� ���������</title>
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
				echo("<p class='alert alert-success'>�������� ������� ������</p>");
			else
				echo("<p class='alert alert-error'>������ ��������</p>");		
		}
		else
		{
			printf("<p class='alert alert-danger'>� ��� ������������ ���� ��� �������� ���������</p>");	
		}
	?>
    <? include('parts/footer.php'); ?>

</div>

</body>
</html>