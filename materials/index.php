<? require($_SERVER['DOCUMENT_ROOT']."/include/head_before.php"); ?>
<?
$page = 1;
if(isset($_GET['page'])){
	$page = (int)htmlspecialchars($_GET['page']);
}

$predmet = null;
if(isset($_GET['predmet'])){
	$predmet = htmlspecialchars($_GET['predmet']);
}

$semestr = 0;
if(isset($_GET['semestr'])){
	$semestr=(int)htmlspecialchars($_GET['semestr']);
}

//все предметы по семестрам
$dbPredmets=$dbWorker->query("SELECT * FROM predmets ORDER BY title_predmet ASC");

while($predmetRes = $dbPredmets->fetch()){
	$arSemestrPredmets[(int)$predmetRes['semestr']][]= array($predmetRes['title_predmet_english'],$predmetRes['title_predmet']);
	$arEnglishToRussianPredmet[$predmetRes['title_predmet_english']]=$predmetRes['title_predmet'];
	$arPredmets[$predmetRes['title_predmet_english']] = array($predmetRes['title_predmet_english'],$predmetRes['title_predmet']);
}

//собираем текст запроса для выбранных данных
$query=" FROM materials M INNER JOIN predmets P ON M.predmetid=P.id";
if($semestr>0){
	$query.=" WHERE P.semestr = :semestr";
}
if($predmet!=null){
	if(!strpos($query,"WHERE")>0)
		$query.=" WHERE";
	else
		$query.=" AND";
	$query.=" P.title_predmet_english = :predmet";
}
$query.=" ORDER BY P.semestr ASC, P.title_predmet ASC, M.title_material ASC";

//общее количество материалов для выборки
$countMaterials = $dbWorker->prepare("SELECT COUNT(*) ".$query);
if($semestr>0)
	$countMaterials->bindParam(':semestr',$semestr,PDO::PARAM_INT);
if($predmet!=null)
	$countMaterials->bindParam(':predmet',$predmet,PDO::PARAM_INT);
$countMaterials->execute();
$countMaterials = $countMaterials->fetch()[0];

$numberMin=($page-1)*$countMaterialsOnPage;

$queryMaterials="SELECT M.id, M.title_material, M.metakey, M.predmetid, M.link, M.filesize, M.downloads, M.dateadd,
	P.title_predmet, P.title_predmet_english, P.semestr ".$query." LIMIT :min, :count";
$dbMaterials = $dbWorker->prepare($queryMaterials);
if($semestr>0)
	$dbMaterials->bindParam(':semestr',$semestr,PDO::PARAM_INT);
if($predmet!=null)
	$dbMaterials->bindParam(':predmet',$predmet,PDO::PARAM_INT);
$dbMaterials->bindParam(':min',$numberMin,PDO::PARAM_INT);
$dbMaterials->bindParam(':count',$countMaterialsOnPage,PDO::PARAM_INT);
$dbMaterials->execute();

while($material = $dbMaterials->fetch()){
	$arMaterials[$material['id']]=$material;
}
?>
<title>
	ЛГТУ|Материалы
	<?=($predmet!=null?$arEnglishToRussianPredmet[$predmet]:'')?>
	<?=($semestr!=0?$semestr.' семестр':'')?>
</title>

<meta name="description" content="Здесь вы можете скачать лабораторные, методички, графические работы, пособия, курсовые, рефераты по большому количеству дисциплин: дискретная математика, информатика, математический анализ, информационные технологии, история, компьютерная графика, логическое программирование, математическая логика и теория алгоритмов, начертательная геометрия, программирование на ЯВУ, психология, социология, структуры и алгоритмы, технология программирования, физика, философия и другие">
<meta name="Keywords" content="скачать материалы, лабораторные, методички, графические работы, пособия, курсовые, рефераты, дискретная математика, информатика, математический анализ, информационные технологии, история, компьютерная графика, логическое программирование, математическая логика и теория алгоритмов, начертательная геометрия, программирование на ЯВУ, психология, социология, структуры и алгоритмы, технология программирования, физика, философия">
<script>
	predmetSemestr = <? echo json_encode($arSemestrPredmets);?>;
	predmets = <? echo json_encode(array_values($arPredmets));?>;
</script>
<? require($_SERVER['DOCUMENT_ROOT']."/include/head_after.php"); ?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/header.php"); ?>
	<div class="alert alert-info">
		<center>
			<b>Внимание!</b> Если вы хотите помочь развитию сайта, можете загрузить свои материалы, нажав на кнопку: 
			<a href = "/upload/" class="btn btn-info">Добавить</a>
		</center>
	</div>
   	<h1>Материалы:</h1>
	<form id="material" class="form-inline">
		<select name="semestr" id="semestr" class="form-control">');
			<option value="none" selected>Все семестры</option>
			<?for($i=1;$i<=10;$i++){?>
				<option value="<?=$i?>" <?=$semestr==$i?'selected':''?>><?=$i?></option>
			<?}?>
		</select>    
		<select id="selectPredmet" name="predmet" class="form-control" predmet="<?=$predmet?>">
			<option value="none" selected>Все предметы</option>
		</select>
        <a id="selectButton" class="btn btn-primary">Выбрать</a>
    </form>
	<?if($countMaterials>0){?>
		<nav>
			<center>
				<ul class='pagination'>
					<?if($countMaterials >= $countMaterialsOnPage)
						for($i=1;$i<($countMaterials/$countMaterialsOnPage+1);$i++){
							if(($countMaterials/$countMaterialsOnPage>8)
								&& (($i>2 && $i<($page-1))
									|| (($i<($countMaterials/$countMaterialsOnPage)-1) && $i>($page+1)))){
								if($i==3 || $i==(($page+2))) echo '<li><a>...</a></li>';
								continue;
							}?>
							<li <?=$page==$i?"class='active'":''?>>
								<a href='/materials/<?=$predmet!=null?$predmet.'/':''?>
									<?=$semestr!=0?'semestr'.$semestr.'/':''?>
									<?='page'.$i.'/'?>'><?=$i?></a></li>
						<?}?>
				</ul>
			</center>
		</nav>
		<h4>Количество материалов: <?=$countMaterials?></h4>
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th><span class="glyphicon glyphicon-time"></span></th>
					<th class="td_material_predmet">Предмет</th>
					<th>Описание</th>
					<th>Размер</th>
					<th><center><span class="glyphicon glyphicon-download"></span></center></th>
					<th><center><span class="glyphicon glyphicon-download-alt"></span></center></th>
				</tr>
			</thead>
			<tbody>
			<? foreach($arMaterials as $material){ ?>
				<tr>
					<td class="td_material"><a href="/materials/semestr<?=$material['semestr']?>/"><?=$material['semestr']?></a></td>
					<td class="td_material_predmet"><a href="/materials/<?=$material['title_predmet_english']?>/"><?=$material['title_predmet']?></a></td>
					<td class="td_material"><a href="/downloads/<?=$material['id']?>/"><?=$material['title_material']?></a></td>
					<td class="td_material_filesize"><?=$material['filesize']?> Кб</td>
					<td class="td_material_filesize"><center><?=$material['downloads']?></center></td>
					<td class="td_material"><a href="/downloads/<?=$material['id']?>/"><center><span class="glyphicon glyphicon-download-alt"></span></center></a></td>
				</tr>
			<?}?>
			</tbody>
		</table>
		<nav>
		<center>
			<ul class='pagination'>
				<?if($countMaterials >= $countMaterialsOnPage)
					for($i=1;$i<($countMaterials/$countMaterialsOnPage+1);$i++){
						if(($countMaterials/$countMaterialsOnPage>8)
							&& (($i>2 && $i<($page-1))
								|| (($i<($countMaterials/$countMaterialsOnPage)-1) && $i>($page+1)))){
							if($i==3 || $i==(($page+2))) echo '<li><a>...</a></li>';
							continue;
						}?>
						<li <?=$page==$i?"class='active'":''?>>
							<a href='/materials/<?=$predmet!=null?$predmet.'/':''?>
									<?=$semestr!=0?'semestr'.$semestr.'/':''?>
									<?='page'.$i.'/'?>'><?=$i?></a></li>
					<?}?>
			</ul>
		</center>
	</nav>
	<?}else{?>
 		<p><h4>В данном разделе материалов не обнаружено</h4>
	<?}?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/footer.php"); ?>
