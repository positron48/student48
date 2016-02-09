<? require($_SERVER['DOCUMENT_ROOT']."/include/head_before.php"); ?>
<?
	$page = 1;
	if(isset($_GET['page'])){
		$page = (int)htmlspecialchars($_GET['page']);
	}
	
	$id = 0;
	if(isset($_GET['id'])){
		$id = (int)htmlspecialchars($_GET['id']);
	}
?>
<title>
<?
	$title="ЛГТУ|Новости";
	if($id>0){
		$dbNews = $dbWorker->prepare('SELECT * FROM news WHERE id = ?');
		$dbNews->execute(array($id));

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
			<h5>Добавлено: <?=date('d.m.Y г. h:i ',strtotime($currentNews['datecreate']));?>  Просмотров:<?=$currentNews['views']?></h5>
			<br><?=$currentNews['fullcontent']?>
		</div>
<?
		$views=$currentNews['views']+1;	
		$updateNews = $dbWorker->prepare("UPDATE news SET views = ? WHERE id = ?");
		$updateNews->execute(array($views,$id));
		$updateNews = $dbWorker->prepare("UPDATE news SET dateview = ? WHERE id = ?");
		$date = date("Y-m-d H:i:s ");
		$updateNews->execute(array($date,$id));
	} else {
?>
		<p><h2><center>Новость не существует</h2></center>
<?}?>		
<? } else { //=======================================список новостей ==========================================?>
	<?

		$number_min=($page-1)*$countNewsOnPage;
		$dbNews=$dbWorker->prepare("SELECT * FROM news ORDER BY id DESC LIMIT :min, :count");
		$dbNews->bindParam(':min',$number_min,PDO::PARAM_INT);
		$dbNews->bindParam(':count',$countNewsOnPage,PDO::PARAM_INT);
		$dbNews->execute();
		$countNews = $dbWorker->query("SELECT COUNT(*) FROM news")->fetch()[0];
	?>
	<p><h1>Новости:</h1>
	<hr>
	<? while($news = $dbNews->fetch()){ //выводим по 2 штуки в строку?>
		<div class="row">
			<div class="col-xs-6" align="justify">
				<h2><?=$news['title_news']?></h2>
				<h5>Добавлено: <?=date('d.m.Y г. ',strtotime($news['datecreate']));?>  Просмотров:<?=$news['views']?></h5>
				<br>
				<p><?=$news['introtext']?></p>
				<p><a class="btn btn-info" href="http://<?=$_SERVER['SERVER_NAME']?>/news/<?=$news['id']?>/">Подробнее</a></p>
			</div>
		<?if($news = $dbNews->fetch()){ ?>
			<div class="col-xs-6" align="justify">
				<h2><?=$news['title_news']?></h2>
				<h5>Добавлено: <?=date('d.m.Y г. ',strtotime($news['datecreate']));?>  Просмотров:<?=$news['views']?></h5>
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
				<li <?=$page==$i?'class="active"':''?>>
					<a href='http://<?=$_SERVER['SERVER_NAME']?>/news/page<?=$i?>/'><?=$i?></a>
				</li>
			<? } ?>
			</ul>
		</center>
	</nav>
<? } ?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/footer.php"); ?>