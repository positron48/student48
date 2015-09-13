<? require($_SERVER['DOCUMENT_ROOT']."/include/head_before.php"); ?>
	<title>
	<?
		$title="ЛГТУ|Новости";
		if(isset($_REQUEST['id']) && $_REQUEST['id']>0){
			$id=(int)$_REQUEST['id'];
			$dbNews = $dbWorker->query('SELECT * FROM news WHERE id = '.$id);
      if($currentNews = $dbNews->fetch())
				$title.=": ".$currentNews['title_news'];
		}
		echo $title;
	?>
	</title>
<? require($_SERVER['DOCUMENT_ROOT']."/include/head_after.php"); ?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/header.php"); ?>
<? if(isset($_REQUEST['id'])){ 
	if($currentNews){
?>
		<div>
			<h2><?=$currentNews['title_news']?></h2>
			<h5>Добавлено:<?=$currentNews['datecreate']?>  Просмотров:<?=$currentNews['views']?></h5>
			<br><?=$currentNews['fullcontent']?>
		</div>
<?
		$views=$currentNews['views']+1;	
		$dbWorker->query("UPDATE news SET views='$views' WHERE id='$id'");
		$dbWorker->query("UPDATE news SET dateview='".date("Y-m-d H:i:s ")."' WHERE id='$id'");
	} else {
?>
		<p><h2><center>Новость не существует</h2></center>
<?}?>		
<? } else { //=======================================список новостей ==========================================?>
	<?
		if(isset($_REQUEST['page'])){
			$page=(int)$_REQUEST['page'];
			$number_min=($page-1)*$countNewsOnPage;
			$dbNews=$dbWorker->query("SELECT * FROM news ORDER BY id DESC LIMIT $number_min, $countNewsOnPage");
		}
		else
		{
			$dbNews=$dbWorker->query("SELECT * FROM news ORDER BY id DESC LIMIT $countNewsOnPage");	
		}
		$countNews = $dbWorker->query("SELECT COUNT(*) FROM news")->fetch()[0];
	?>
	<p><h1>Новости:</h1>
	<hr>
	<? while($news = $dbNews->fetch()){ //выводим по 2 штуки в строку?>
		<div class="row">
			<div class="col-xs-6" align="justify">
				<h2><?=$news['title_news']?></h2>
				<h5>Добавлено:<?=$news['datecreate']?>  Просмотров:<?=$news['views']?></h5>
				<br>
				<p><?=$news['introtext']?></p>
				<p><a class="btn btn-info" href="<?=$news['id']?>/">Подробнее</a></p>
			</div>
		<?if($news = $dbNews->fetch()){ ?>
			<div class="col-xs-6" align="justify">
				<h2><?=$news['title_news']?></h2>
				<h5>Добавлено:<?=$news['datecreate']?>  Просмотров:<?=$news['views']?></h5>
				<br>
				<p><?=$news['introtext']?></p>
				<p><a class="btn btn-info" href="http://<?=$_SERVER['SERVER_NAME']?>/news/<?=$news['id']?>/">Подробнее</a></p>
			</div>
		<?}?>
		</div>
	<? } ?>
	</div>
	<nav>
		<center>
			<ul class='pagination'>
			<? for($i=1;$i<($countNews/$countNewsOnPage+1);$i++){ ?>
				<li <?=(($_GET['page']==$i || (!isset($_GET['page']) && $i == 1))?'class="active"':'')?>>
					<a href='http://<?=$_SERVER['SERVER_NAME']?>/news/page<?=$i?>/'><?=$i?></a>
				</li>
			<? } ?>
			</ul>
		</center>
	</nav>
<? } ?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/footer.php"); ?>