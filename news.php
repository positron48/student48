<?
	include('parts/settings.php');

	$handle = mysql_query("SELECT COUNT(*) FROM news", $dbconnect);
	$number_news  = mysql_fetch_array($handle);	
	
	if(isset($_GET['id']))
	{
		$date=date("Y-m-d H:i:s "); 
		$id=_filter($_GET['id']);
		$dbdata=mysql_query("SELECT * FROM news WHERE id='$id'", $dbconnect);
	}
	else if(isset($_GET['page']))
	{
		$page=_filter($_GET['page']);
		$number_min=($page-1)*$number_news_on_page;
		$dbdata=mysql_query("SELECT * FROM news ORDER BY id DESC LIMIT $number_min, $number_news_on_page", $dbconnect);
	}
	else
	{
		$dbdata=mysql_query("SELECT * FROM news ORDER BY id DESC LIMIT $number_news_on_page", $dbconnect);	
	}
	$open_news=false;
?>
<!DOCTYPE html>
<html>
<head>
<title>
<?
	$title="ЛГТУ|Новости";
	if(isset($_GET['id']) && $_GET['id']>0 )
		if($pagedata=mysql_fetch_array($dbdata))
		{
			$title=$title.": ".$pagedata['title_news'];
			$open_news=true;
		}
	$title=$title;
	printf("%s",$title);
?>
</title>
<? include('parts/head.php'); ?>
</head>
<body>

	<? include("parts/top.php"); ?>
   	<? include('parts/header.php'); ?>
    <div class="container">
                       <?
							if(isset($_GET['id']))
							{
								if($open_news)
								{
									printf('
									<div>
                                        <h2>%s</h2>
										<h5> Добавлено:%s  Просмотров:%s</h5>
										<br>%s
									</div>
									',$pagedata['title_news'],$pagedata['datecreate'],$pagedata['views'],$pagedata['fullcontent']);
									$views=$pagedata['views']+1;	
									mysql_query("UPDATE news SET views='$views' WHERE id='$id'");
									mysql_query("UPDATE news SET dateview='$date' WHERE id='$id'");
									printf("<table><tr><td>
										<!-- Put this script tag to the place, where the Share button will be -->
										<script type='text/javascript'>
										document.write(VK.Share.button({
											url: '%s',
											title: '%s',
											description: '","http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"],$title);
											printf('%s',_filter($pagedata['fullcontent']));
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
									print('<center><!-- Put this div tag to the place, where the Comments block will be -->
										<div id="vk_comments"></div>
										<script type="text/javascript">
										VK.Widgets.Comments("vk_comments", {limit: 10, width: "690", attach: "*"});
										</script></center>');
								}
								else
									echo("<p><h2><center>Новость не обнаружена</h2></center>");
							}
							else
							{
								echo("<p><h1>Новости:</h1>");
								                    
                    			if($check)
									print('<h4><a href="addnews.php" class="btn pull-right">Добавить новость</a></h4>');
                                
								while($pagedata=mysql_fetch_array($dbdata))
								{
									printf('
									   <hr>
                                       <div class="row-fluid">
                                            <div class="span6" align="justify">');
									if($check)
										printf('<a href="delete_news.php?id=%s" class="pull-right" onclick="if(!confirm(\'Точно хочешь удалить?\')) return false;"><i class="icon-remove"></i></a>
                                                <a href="edit_news.php?id=%s" class="pull-right"><i class="icon-edit"></i></a>
                                                ',$pagedata['id'],$pagedata['id']);	
									printf('<h2>%s</h2>
										<h5>Добавлено:%s  Просмотров:%s</h5><br>
										<p>%s</p>
										<p><a class="btn" href="news.php?id=%s">Подробнее</a></p></div>
										',$pagedata['title_news'],$pagedata['datecreate'],$pagedata['views'],$pagedata['introtext'],$pagedata['id']);
                                    if($pagedata=mysql_fetch_array($dbdata))
                                    {
                                        printf('
                                            <div class="span6" align="justify">');
    									if($check)
    										printf('<a href="delete_news.php?id=%s" class="pull-right" onclick="if(!confirm(\'Точно хочешь удалить?\')) return false;"><i class="icon-remove"></i></a>
                                                    <a href="edit_news.php?id=%s" class="pull-right"><i class="icon-edit"></i></a>
													',$pagedata['id'],$pagedata['id']);	
    									printf('<h2>%s</h2>
    										<h5>Добавлено:%s  Просмотров:%s</h5><br>
    										<p>%s</p>
    										<p><a class="btn" href="news.php?id=%s">Подробнее</a></p></div></div>
    										',$pagedata['title_news'],$pagedata['datecreate'],$pagedata['views'],$pagedata['introtext'],$pagedata['id']);
                                    }
								}	
								echo("</div><center>
                                        <div class='pagination'>  
				                        <ul>");
								for($i=1;$i<($number_news[0]/$number_news_on_page+1);$i++)
                                    if($_GET['page']==$i || (!isset($_GET['page']) && $i == 1))
                                        printf("<li class='active'><a href='news.php?page=%s'> %s</a></li>",$i,$i);	
                                    else
									   printf("<li><a href='news.php?page=%s'> %s</a></li>",$i,$i);	
								echo("</center></ul></div>");				
							}
						?>
                </td>
            </tr>
        </table>
	    <div id="footer">
    		<? include('parts/footer.php'); ?>
        </div>    
	</div>
    </center>
</div>

</body>
</html>