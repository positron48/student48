<?
	include('parts/settings.php');
	$query="FROM materials, predmets WHERE materials.predmetid=predmets.id";
	if(isset($_GET['semestr']) && isset($_GET['predmet']))
	{
		if($_GET['semestr']!="none")
		{
			$semestr=$_GET['semestr'];
			$query=$query." AND predmets.semestr='$semestr'";
		}
		if($_GET['predmet']!="none")
		{
			$predmet=$_GET['predmet'];
			$query=$query." AND predmets.title_predmet_english='$predmet'";
		}
	}
	
	$query=$query." ORDER BY predmets.semestr ASC, title_predmet ASC, title_material ASC";
	$q="SELECT COUNT(*) ".$query;
	$handle = mysql_query("SELECT COUNT(*) $query", $dbconnect);
	$number_materials  = mysql_fetch_array($handle);

	if(isset($_GET['page']))
	{
		$page=$_GET['page'];
		$number_min=($page-1)*$number_materials_on_page;
		$query1="SELECT materials.id, title_material, metakey, predmetid, link, filesize, downloads, dateadd, title_predmet, title_predmet_english, semestr ".$query." LIMIT $number_min, $number_materials_on_page";
		$query="SELECT * ".$query." LIMIT $number_min, $number_materials_on_page";
	}
	else
	{
		$query1="SELECT materials.id, title_material, metakey, predmetid, link, filesize, downloads, dateadd, title_predmet, title_predmet_english, semestr ".$query." LIMIT $number_materials_on_page";
		$query="SELECT * ".$query." LIMIT $number_materials_on_page";
	}
	
	$dbdata=mysql_query($query,$dbconnect);
	$dbdata1=mysql_query($query1,$dbconnect);
	$dbdata2=mysql_query("SELECT DISTINCT title_predmet_english, title_predmet FROM predmets ORDER BY title_predmet ASC");
	$dbdata3=mysql_query("SELECT title_predmet FROM predmets WHERE title_predmet_english='$predmet'");
	$dbdata4=mysql_query("SELECT * FROM predmets ORDER BY semestr, title_predmet");
	$dbdata5=mysql_query("SELECT DISTINCT title_predmet_english, title_predmet FROM predmets ORDER BY title_predmet");
	$pagedata3=mysql_fetch_array($dbdata3);

	if($_SESSION['password']=='ololo' && $_SESSION['user']=='admin')
	{
		$check=true;
	}
?>
<!DOCTYPE html>
<html>
<head>
<?
	$title="<title>ЛГТУ|Материалы ";
	if($_GET['predmet']!='none')
		$title=$title.$pagedata3['title_predmet'];
	if($_GET['semestr']!='none')
		$title=$title." ".$_GET['semestr']." семестр";
	$title=$title."</title>";
	printf("%s",$title);
?>
<? include('parts/head.php'); ?>
<meta name="description" content="Здесь вы можете скачать лабораторные, методички, графические работы, пособия, курсовые, рефераты по большому количеству дисциплин: дискретная математика, информатика, математический анализ, информационные технологии, история, компьютерная графика, логическое программирование, математическая логика и теория алгоритмов, начертательная геометрия, программирование на ЯВУ, психология, социология, структуры и алгоритмы, технология программирования, физика, философия и другие">
<meta name="Keywords" content="скачать материалы, лабораторные, методички, графические работы, пособия, курсовые, рефераты, дискретная математика, информатика, математический анализ, информационные технологии, история, компьютерная графика, логическое программирование, математическая логика и теория алгоритмов, начертательная геометрия, программирование на ЯВУ, психология, социология, структуры и алгоритмы, технология программирования, физика, философия">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251"></head>
<body>
<script>
	var predmets = new Array(4);
	for(var i=0;i<4;i++)
		predmets[i]=new Array();
	<?
		$i=0;
		while($predmets=mysql_fetch_array($dbdata4))
		{
			printf("predmets[0][%s] = '%s';\n",$i,$predmets['title_predmet_english']."");
			printf("predmets[1][%s] = '%s';\n",$i,$predmets['semestr']);
			printf("predmets[2][%s] = '%s';\n",$i,$predmets['title_predmet']);	
			printf("predmets[3][%s] = '%s';\n",$i,$predmets['id']);	
			$i++;
		}
	?>
	var allpredmets = new Array(2);
	for(var i=0;i<4;i++)
		allpredmets[i]=new Array();
	<?
		$i=0;
		while($allpredmets=mysql_fetch_array($dbdata5))
		{
			printf("allpredmets[0][%s] = '%s';\n",$i,$allpredmets['title_predmet_english']."");
			printf("allpredmets[1][%s] = '%s';\n",$i,$allpredmets['title_predmet']);	
			$i++;
		}
	?>
	function changeSem(form)
	{
		if(form.predmet.options.length>1)
			form.predmet.options.length=1;
		if(form.semestr.options[form.semestr.selectedIndex].value=='none')
		{	
			for(var j=0;j<allpredmets[0].length;j++)
			{
				if(allpredmets[1][j]!="")
				{
					form.predmet.options[form.predmet.length]=new Option(allpredmets[1][j],allpredmets[0][j]);
					if(allpredmets[0][j]==<? printf("'%s'",$_GET['predmet']) ?>)
						form.predmet.options[form.predmet.length-1].selected=true;
				}
			}
		}
		else
		{
			for(var j=0;j<predmets[0].length;j++)
				if(predmets[1][j]>0)
				{
					if(predmets[1][j]==form.semestr.options[form.semestr.selectedIndex].value)
					{
						form.predmet.options[form.predmet.length]=new Option(predmets[2][j],predmets[0][j]);
						if(predmets[0][j]==<? printf("'%s'",$_GET['predmet']) ?>)
							form.predmet.options[form.predmet.length-1].selected=true;
					}
				}
		}
		
	}
	changeSem(document.getElementById("material"));
</script>
<? include("parts/top.php"); ?>
<? include('parts/header.php'); ?>
    <div class="container">
    <div class="alert alert-info">
        <center>
            <b>Внимание!</b> Если вы хотите помочь развитию сайта, можете загрузить свои материалы, нажав на кнопку: 
            <a href = "upload.php" class="btn btn-info">Добавить</a>
        </center>
    </div>
   	<h1>Материалы:</h1>
		<?
		        echo('<form action="materials.php" method="get" id="material" class="form-inline">
                   	<select name="semestr" id="semestr" onChange="changeSem(this.form)">');
							if($_GET['semestr']=="0") echo('<option value="none" selected>Все семестры</option>'); else echo('<option value="none">Все семестры</option>');
                       		if($_GET['semestr']=="1") echo('<option value="1" selected>1</option>'); else echo('<option value="1">1</option>');
							if($_GET['semestr']=="2") echo('<option value="2" selected>2</option>'); else echo('<option value="2">2</option>');
							if($_GET['semestr']=="3") echo('<option value="3" selected>3</option>'); else echo('<option value="3">3</option>');
							if($_GET['semestr']=="4") echo('<option value="4" selected>4</option>'); else echo('<option value="4">4</option>');
							if($_GET['semestr']=="5") echo('<option value="5" selected>5</option>'); else echo('<option value="5">5</option>');
							if($_GET['semestr']=="6") echo('<option value="6" selected>6</option>'); else echo('<option value="6">6</option>');
							if($_GET['semestr']=="7") echo('<option value="7" selected>7</option>'); else echo('<option value="7">7</option>');
							if($_GET['semestr']=="8") echo('<option value="8" selected>8</option>'); else echo('<option value="8">8</option>');
							if($_GET['semestr']=="9") echo('<option value="9" selected>9</option>'); else echo('<option value="9">9</option>');
							if($_GET['semestr']=="10") echo('<option value="10" selected>10</option>'); else echo('<option value="10">10</option>');
                        echo('</select>    
                   	<select name="predmet" onChange="submit();">');
						if($_GET['predmet']=="none") echo('<option value="none" selected>Все предметы</option>'); else echo('<option value="none">Все предметы</option>');
		echo('</select>
                    <input type="submit" class="btn" value="Выбрать">
                </form>');
		echo("<div class='pagination'>
                    <center>
                        <ul>");
			$link="materials.php?";
			if(isset($_GET['semestr']))
				$link=$link."semestr=".$_GET['semestr'];
			if(isset($_GET['predmet']))
				$link=$link."&predmet=".$_GET['predmet']."&";
			for($i=1;$i<($number_materials[0]/$number_materials_on_page+1);$i++)
				if($_GET['page']==$i)
					printf("<li class='active'> <a href='$link&page=%s'> %s</a> </li>",$i,$i);
				else if(!isset($_GET['page']) && $i==1)
					printf("<li class='active'> <a href='$link&page=%s'> %s</a> </li>",$i,$i);
				else 
					printf("<li><a href='$link&page=%s'> %s</a></li>",$i,$i);
			echo("</ul></center></div>");		

		if($number_materials[0])
		{
			echo('<table class="table table-striped table-bordered table-condensed">
                    <thead>
						<tr>
						<td><i class="icon-time"></i></td>
						<td>Предмет</td>
						<td>Описание</td>
						<td>Размер</td>
						<td><i class="icon-download"></td>
						<td><i class="icon-download-alt"></i></td>');
			if($check)
				print('<td><center><b>Edit</b></center></td>');
			print('</tr></thead>');
			echo("Количество материалов: $number_materials[0]");
			while($pagedata=mysql_fetch_array($dbdata))
			{	
				$pagedata1=mysql_fetch_array($dbdata1);
				printf('<tr><td><a href="materials.php?semestr=%s&predmet=none">%s</a></td>
							<td class="td_material_predmet"><a href="materials.php?semestr=none&predmet=%s">%s</a></td>
							<td><a href="downloads.php?id=%s">%s</a></td>
							<td class="td_material_filesize">%s Кб</td>
							<td class="td_material_filesize">%s</td>
							<td><a href="downloads.php?id=%s"><i class="icon-download-alt"></i></a></td>',
							$pagedata1['semestr'],$pagedata1['semestr'],
							$pagedata1['title_predmet_english'],$pagedata1['title_predmet'],
							$pagedata1['id'], $pagedata1['title_material'],
							$pagedata['filesize'],$pagedata['downloads'],$pagedata1['id']);
				if($check): ?>
					<td><a href="edit_materials.php?id=<? printf("%s",$pagedata1['id']);?>"><i class="icon-edit"></i></a>
					<a href="delete_materials.php?id=<? printf("%s",$pagedata1['id']);?>" onClick="if(!confirm('Точно хочешь удалить?')) return false;"><i class="icon-remove"></i></a></td>
		<?		endif;
			}
            echo('</table>');
			echo("<div class='pagination'>
                    <center>
                        <ul>");
			$link="materials.php?";
			if(isset($_GET['semestr']))
				$link=$link."semestr=".$_GET['semestr'];
			if(isset($_GET['predmet']))
				$link=$link."&predmet=".$_GET['predmet']."&";
			for($i=1;$i<($number_materials[0]/$number_materials_on_page+1);$i++)
				if($_GET['page']==$i)
					printf("<li class='active'> <a href='$link&page=%s'> %s</a> </li>",$i,$i);
				else if(!isset($_GET['page']) && $i==1)
					printf("<li class='active'> <a href='$link&page=%s'> %s</a> </li>",$i,$i);
				else 
					printf("<li><a href='$link&page=%s'> %s</a></li>",$i,$i);
			echo("</ul></center></div>");		
		}
		else
		{
			echo('<p><h4>В данном разделе материалов не обнаружено</h4>');
		}
		?>
                </td>
            </tr>
        </table>
    		<? include('parts/footer.php'); ?>  
	</div>
    </center>
</div>
<script>
	changeSem(document.getElementById('material'));
</script>
</body>
</html>