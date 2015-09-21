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
		$arSemestrPredmets[]=$predmetRes;
		$arEnglishToRussianPredmet[$predmetRes['title_predmet_english']]=$predmetRes['title_predmet'];
	}

	//собираем текст запроса для выбранных данных
	$query=" FROM materials M INNER JOIN predmets P ON M.predmetid=P.id";
	if($semestr>0){
		$query.=" WHERE P.semestr='$semestr'";
	}
	if($predmet!=null)
	{
		if(!strpos($query,"WHERE")>0)
			$query.=" WHERE";
		else
			$query.=" AND";
		$query.=" P.title_predmet_english='$predmet'";
	}
	$query.=" ORDER BY P.semestr ASC, P.title_predmet ASC, M.title_material ASC";
	
	//общее количество материалов для выборки
	$countMaterials = $dbWorker->query("SELECT COUNT(*) ".$query)->fetch()[0];

	$numberMin=($page-1)*$countMaterialsOnPage;

	$queryMaterials="SELECT M.id, M.title_material, M.metakey, M.predmetid, M.link, M.filesize, M.downloads, M.dateadd,
		P.title_predmet, P.title_predmet_english, P.semestr ".$query." LIMIT $numberMin, $countMaterialsOnPage";
	$dbMaterials = $dbWorker->query($queryMaterials);
	while($material = $dbMaterials->fetch()){
		$arMaterials[$material['id']]=$material;
	}
	
	
	/*$dbdata=mysql_query($query,$dbconnect);
	$dbdata1=mysql_query($query1,$dbconnect);
	$dbdata2=mysql_query("SELECT DISTINCT title_predmet_english, title_predmet FROM predmets ORDER BY title_predmet ASC");
	$dbdata3=mysql_query("SELECT title_predmet FROM predmets WHERE title_predmet_english='$predmet'");
	$dbdata4=mysql_query("SELECT * FROM predmets ORDER BY semestr, title_predmet");
	$dbdata5=mysql_query("SELECT DISTINCT title_predmet_english, title_predmet FROM predmets ORDER BY title_predmet");
	$pagedata3=mysql_fetch_array($dbdata3);*/
?>
	<title>
		ЛГТУ|Материалы
		<?=($predmet!=null?$arEnglishToRussianPredmet[$predmet]:'')?>
		<?=($semestr!=0?$semestr.' семестр':'')?>
	</title>

	<meta name="description" content="Здесь вы можете скачать лабораторные, методички, графические работы, пособия, курсовые, рефераты по большому количеству дисциплин: дискретная математика, информатика, математический анализ, информационные технологии, история, компьютерная графика, логическое программирование, математическая логика и теория алгоритмов, начертательная геометрия, программирование на ЯВУ, психология, социология, структуры и алгоритмы, технология программирования, физика, философия и другие">
	<meta name="Keywords" content="скачать материалы, лабораторные, методички, графические работы, пособия, курсовые, рефераты, дискретная математика, информатика, математический анализ, информационные технологии, история, компьютерная графика, логическое программирование, математическая логика и теория алгоритмов, начертательная геометрия, программирование на ЯВУ, психология, социология, структуры и алгоритмы, технология программирования, физика, философия">
<? require($_SERVER['DOCUMENT_ROOT']."/include/head_after.php"); ?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/header.php"); ?>
	<div class="alert alert-info">
		<center>
			<b>Внимание!</b> Если вы хотите помочь развитию сайта, можете загрузить свои материалы, нажав на кнопку: 
			<a href = "upload.php" class="btn btn-info">Добавить</a>
		</center>
	</div>
   	<h1>Материалы:</h1>
	<form action="materials.php" method="get" id="material" class="form-inline">
		<select name="semestr" id="semestr" onChange="changeSem(this.form)" class="form-control">');
			<option value="none" selected>Все семестры</option>
			<?for($i=0;$i<10;$i++){?>
				<option value="<?=$i?>" <?=$semestr==$i?'selected':''?>><?=$i?></option>
			<?}?>
		</select>    
		<select name="predmet" onChange="submit();" class="form-control">');
			<option value="none" selected>Все предметы</option>
		</select>
        <input type="submit" class="btn btn-primary" value="Выбрать">
    </form>
	<?if($countMaterials>0){?>
		<nav>
			<center>
				<ul class='pagination'>
				<?for($i=1;$i<($countMaterials/$countMaterialsOnPage+1);$i++){?>
					<li <?=$page==$i?"class='active'":''?>>
					<a href='http://<?=$_SERVER['SERVER_NAME']?>/materials/<?=$predmet!=null?$predmet.'/':''?>
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
				<tr><td class="td_material"><a href="http://<?=$_SERVER['SERVER_NAME']?>/materials/semestr<?=$material['semestr']?>/"><?=$material['semestr']?></a></td>
					<td class="td_material_predmet"><a href="http://<?=$_SERVER['SERVER_NAME']?>/materials/<?=$material['title_predmet_english']?>/"><?=$material['title_predmet']?></a></td>
					<td class="td_material"><a href="http://<?=$_SERVER['SERVER_NAME']?>/downloads/<?=$material['id']?>/"><?=$material['title_material']?></a></td>
					<td class="td_material_filesize"><?=$material['filesize']?> Кб</td>
					<td class="td_material_filesize"><center><?=$material['downloads']?></center></td>
					<td class="td_material"><a href="http://<?=$_SERVER['SERVER_NAME']?>/downloads/<?=$material['id']?>/"><center><span class="glyphicon glyphicon-download-alt"></span></center></a></td>
				</tr>
			<?}?>
			</tbody>
		</table>
		<nav>
		<center>
			<ul class='pagination'>
			<?for($i=1;$i<($countMaterials/$countMaterialsOnPage+1);$i++){?>
				<li <?=$page==$i?"class='active'":''?>>
				<a href='http://<?=$_SERVER['SERVER_NAME']?>/materials/<?=$predmet!=null?$predmet.'/':''?>
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
