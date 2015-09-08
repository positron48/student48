<?
	include('../parts/settings.php');
	if(isset($_GET['id']))
		$id=$_GET['id'];
	$dbdata=mysql_query("SELECT * FROM shpora_messages WHERE shp_msg_id='$id'", $dbconnect);
?>
<!DOCTYPE html>
<html>
<head>
<title>ЛГТУ | Сообщения</title>
<? include('../parts/head.php'); ?>
</head>
<body>
<? include("../parts/top.php"); ?>
<? include('../parts/header.php'); ?>
<div class="container">
                	<h1>Шпора!</h1><br />
                    <? printf('<a href="themes.php?id=%s"><h3>Вернуться к теме</a></h3>',$_GET['them_id']); ?>
                    <br>
                    <?
						$pagedata=mysql_fetch_array($dbdata);
						$views=$pagedata['shp_msg_views']+1;	
						mysql_query("UPDATE shpora_messages SET shp_msg_views='$views' WHERE shp_msg_id='$id'");
							printf('
								<div class="shpora_msg">
									<h3>%s <div class="pull-right">Просмотров:%s</div></h3><br />
										<div class="shpora_msg_content">
											%s
										</div>
								</div>
								',$pagedata['shp_msg_title'],$pagedata['shp_msg_views'],$pagedata['shp_msg_content']);
					?>
                    <? printf("<table><tr><td>
									<!-- Put this script tag to the place, where the Share button will be -->
									<script type='text/javascript'>
									document.write(VK.Share.button({
										url: '%s',
										title: '%s',
										description: '","http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"],$pagedata['shp_msg_title']);
										printf('%s',_filter($pagedata['shp_msg_content']));
										print("',
										noparse: false
									},{type: 'button', text: 'Сохранить'}));
									</script></td>");
						print('<td>
									<!-- Put this div tag to the place, where the Like block will be -->
									<div class="like"><div id="vk_like"></div></div>
									<script type="text/javascript">
									VK.Widgets.Like("vk_like", {type: "full"});
									</script>
										</td></tr></table>'); 
					?>
    		<? include('../parts/footer.php'); ?>
</div>

</body>
</html>