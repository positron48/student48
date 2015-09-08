<?
	include('parts/settings.php');
	if(isset($_GET['id']))
	{
		$id=_filter($_GET['id']);
		$dbdata=mysql_query("SELECT title_material, metakey, link, filesize, downloads, dateadd, title_predmet, semestr FROM materials, predmets WHERE predmetid=predmets.id AND materials.id=$id", $dbconnect);
		$pagedata=mysql_fetch_array($dbdata);
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>
<? 
	$title="ЛГТУ|Скачать: ".$pagedata['title_material']." / ".$pagedata['title_predmet']." (".$pagedata['metakey'].")";
	printf("%s",$title)
?>
</title>
<? include('parts/head.php'); ?>
<meta http-equiv="Refresh" content="1; URL=<? printf('%s',$pagedata['link']); ?>">
<body>

<? include("parts/top.php"); ?>
<? include('parts/header.php'); ?>
<div class="container">
   	<h2>Информация о файле:</h2>
                    <table class="table table-striped table-bordered table-condensed">
                        <tr><td><b>Название: </b></td><td> <? printf("%s",$pagedata['title_material']) ?></td></tr>
                        <tr><td><b>Предмет: </b></td><td> <? printf("%s",$pagedata['title_predmet']) ?></td></tr>
                        <tr><td><b>Добавлено: </b></td><td> <? printf("%s",$pagedata['dateadd']) ?></td></tr>
                        <tr><td><b>Семестр: </b></td><td> <? printf("%s",$pagedata['semestr']) ?></td></tr>
                        <tr><td><b>Размер: </b></td><td> <? printf("%s Kb",$pagedata['filesize']) ?></td></tr>
                        <tr><td><b>Cкачано: </b></td><td> <? printf("%s",$pagedata['downloads']) ?></td></tr>
                    </table>
                	<h4>Перед тем как скачать файл, ознакомьтесь, пожалуйста, с нашими условиями:</h4>
					<p>1. Все материалы, расположенные на сайте выложены для ознакомления. За использование материалов в личных интересах администрация сайта ответственности не несет. Размещение на других ресурсах разрешается только в случае размещения ссылки на данный ресурс.
                    <p>2. Все файлы, расположенные на сервере проверены на отсутствие вирусов, иные файлы, ссылки на которые расположены у нас, рекомендательно просим проверять антивирусными программами.
                    <p>3. Все файлы мы предоставляем согласно схеме "AS IS" ("Как есть"), т.е. за все возможные последствия после их применения мы ответственности не несем.
                    <p>4. Для скачивания нажмите правой кнопкой мыши на ссылке и выберите пункт "Сохранить как".
					
                    
                	<center>
					  
                    <?
                    	printf('<h4>Если скачивание не началось автоматически, перейдите по ссылке:</h4><a href="%s" class="btn btn-link"><h3>Скачать</h3></a>',$pagedata['link']);
						$downloads=$pagedata['downloads']+1;
						mysql_query("UPDATE materials SET downloads='$downloads' WHERE id='$id'");
					?>
                    </center>
                    <? printf("<table><tr><td>
						<!-- Put this script tag to the place, where the Share button will be -->
						<script type='text/javascript'>
						document.write(VK.Share.button({
							url: '%s',
							title: '%s',
							description: '","http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"],$title);
							printf('<b>Название:</b> %s, <br /> <b>Предмет:</b> %s, <br /><b>Добавлено:</b> %s, <b>Семестр:</b> %s,<br /> <b>Размер:</b> %s, Kb<br /> <b>Cкачано:</b> %s.<br />'
							,$pagedata['title_material'],$pagedata['title_predmet'],$pagedata['dateadd'],$pagedata['semestr'],$pagedata['filesize'],$pagedata['downloads']);
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
					</td></tr></table>'); ?>
                    <br>
                    <center>
                    <!-- Put this div tag to the place, where the Comments block will be -->
                    <div id="vk_comments"></div>
                    <script type="text/javascript">
                    VK.Widgets.Comments("vk_comments", {limit: 10, width: "690"});
                    </script>
                    </center>
                </td>
            </tr>
    		<? include('parts/footer.php'); ?>
	</div>
    </center>
</div>

</body>
</html>