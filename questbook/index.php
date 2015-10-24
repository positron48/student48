<? require($_SERVER['DOCUMENT_ROOT']."/include/head_before.php"); ?>
<?
$page = 1;
if(isset($_GET['page']))
	$page = (int)htmlspecialchars($_GET['page']);
$minNumber=($page-1)*$countMessagesOnPage;
$questbookDb = $dbWorker->prepare("SELECT * FROM questbook ORDER BY id DESC LIMIT :min, :max");
$questbookDb->bindParam(':min',$minNumber,PDO::PARAM_INT);
$questbookDb->bindParam(':max',$countMessagesOnPage,PDO::PARAM_INT);
$questbookDb->execute();

$countMessages = $dbWorker->query("SELECT COUNT(*) FROM questbook")->fetch()[0];

while($message=$questbookDb->fetch()){
	$messages[]=$message;
}
?>
	<title>ЛГТУ | Гостевая</title>
<? require($_SERVER['DOCUMENT_ROOT']."/include/head_after.php"); ?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/header.php"); ?>

<h1>Гостевая</h1><br />
<?	foreach($messages as $pagedata){?>
	<table class="table table-striped table-bordered table-condensed">
		<tr>
			<td><?=$pagedata['user']?>: <?=$pagedata['title_message']?>
				<div class="pull-right">Добавлено: <?=$pagedata['dateadd']?>
				</div>
			</td>
		</tr>
		<tr><td><?=$pagedata['message']?></td></tr>
	</table>
<?	}?>
<center>
	<div>
		<ul class='pagination'>
		<?if($countMessages > $countMessagesOnPage)
			for($i=1;$i<($countMessages/$countMessagesOnPage+1);$i++){?>
				<li <?=($page==$i)?"class='active'":""?>><a href ='/questbook/page<?=$i?>/'> <?=$i?></a></li>
		<?	}?>
		</ul>
	</div>
</center>	
	
<form id="addMessageForm">
	<h2>Добавить сообщение:</h2>
	<div class="form-group">
		<label for="nameUser">Имя:</label>
		<input type="text" id="nameUser" name="user" size="90" class="form-control" />
	</div>
	<div class="form-group">
		<label for="message">Сообщение:</label>
		<textarea cols="69" rows="5" id="message" name="msg" class="form-control" ></textarea>
	</div>
	<div class="form-group">
		<input style="display: none;" type="radio" name="imNotRobot" checked="true" value="N"/>
		<input type="radio" name="imNotRobot" value="Y" /> Я не робот
	</div>
	<button type="submit" class="btn btn-default">Отправить</button>
</form>      

<? require($_SERVER['DOCUMENT_ROOT']."/include/footer.php"); ?>
