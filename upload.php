<? require($_SERVER['DOCUMENT_ROOT']."/include/head_before.php"); ?>
<?
//все предметы по семестрам
$dbPredmets=$dbWorker->query("SELECT semestr, title_predmet_english, title_predmet FROM predmets ORDER BY title_predmet ASC");
$arSemestrPredmets=array();
$arPredmets=array();
while($predmetRes = $dbPredmets->fetch()){
	$arSemestrPredmets[(int)$predmetRes['semestr']][]= array($predmetRes['title_predmet_english'],$predmetRes['title_predmet']);
	$arPredmets[$predmetRes['title_predmet_english']] = array($predmetRes['title_predmet_english'],$predmetRes['title_predmet']);
}
?>
<title>ЛГТУ|Добавление материала</title>

<script>
	predmetSemestr = <? echo json_encode($arSemestrPredmets);?>;
	predmets = <? echo json_encode(array_values($arPredmets));?>;
</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="/files/js/vendor/jquery.ui.widget.js"></script>
<script src="/files/js/jquery.iframe-transport.js"></script>
<script src="/files/js/jquery.fileupload.js"></script>
<style>
	.progress {
		width: 50%;
		margin-left: 15px;
		height: 34px;
		margin-bottom: 0;
	}
</style>
<? require($_SERVER['DOCUMENT_ROOT']."/include/head_after.php"); ?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/header.php"); ?>
<?if(isset($_REQUEST['success'])){?>
	<div id="succes_info" class="alert alert-success"><strong>Материал<?=(isset($_REQUEST['filename'])?' '.$_REQUEST['filename']:'')?>
			успешно добавлен и находится на модерации, спасибо за Ваш вклад в развитие сайта!</strong></div>
<?}?>
<h1>Добавление материала:</h1>
<form id="addMaterial" class="form-inline" action="#">
	<table class="table table-striped table-bordered table-condensed">
		<tr><td><b>Семестр: </b></td><td>
			<select name="semestr" id="semestr" class="form-control">');
				<option value="none" selected>Все семестры</option>
				<?for($i=1;$i<=10;$i++){?>
					<option value="<?=$i?>"><?=$i?></option>
				<?}?>
			</select></td>
		</tr>
		<tr><td><b>Предмет: </b></td><td>
			<select id="selectPredmet" name="predmet" class="form-control">
				<option value="none" selected>Все предметы</option>
			</select></td>
		</tr>
		<tr id="another_predmet"><td><b>Название предмета: </b></td><td><input style="width:100%;" class="form-control" type="text" name="new_predmet"></td></tr>
		<tr><td><b>Название материала: </b></td><td><input style="width:100%;" class="form-control" type="text" name="title"></td></tr>
		<tr><td><b>Ключевые слова: </b></td><td><input style="width:100%;" class="form-control" type="text" name="keywords"></td></tr>
		<tr><td><b>Файл: </b></td><td>
			<label class="addbutton">
				<div class="btn btn-info" >Выбрать</div>
				<div class='form-control'>Выберите файл</div>
				<input id="fileupload" type="file" name="files[]" data-url="/files/upload.php"
					onchange="this.previousSibling.previousSibling.innerHTML = this.value"/>
				<div class="progress">
					<div class="progress-bar progress-bar-info progress-bar-striped"
						 role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0">
						<span class="sr-only">40% Complete (success)</span>
					</div>
				</div>
			</label></td>
		</tr>
		<input type="hidden" id="file" name="link">
	</table>
	<input type="submit" class="btn btn-success" value="Отправить">
</form>

<? require($_SERVER['DOCUMENT_ROOT']."/include/footer.php"); ?>
