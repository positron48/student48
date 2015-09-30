<? require($_SERVER['DOCUMENT_ROOT']."/include/head_before.php"); ?>
<title>ЛГТУ | Расчитайте свой рейтинг</title>
<? require($_SERVER['DOCUMENT_ROOT']."/include/head_after.php"); ?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/header.php"); ?>

<script language="javascript">
	function checkIntEkz(minimum,predel,input,num)
	{
		if(isNaN(input.value) || input.value<minimum || input.value>predel)
		{
			alert("значение некорректно, введите значение между " + minimum + " и " + predel);
			input.focus();
			input.select();
		}
		var sem=document.getElementById("ekzsem"+num);
		var ekz=document.getElementById("ekz"+num);
		var hours=document.getElementById("ekzhours"+num);
		if(sem.value!="" && ekz.value!="" && hours.value!="")
		{
			$('#ekzpredmet'+(num+1)).show();
			$('#ekzsem'+(num+1)).focus();
		}
	}
	function checkIntZachet(minimum,predel,input,num)
	{
		if(isNaN(input.value) || input.value<minimum || input.value>predel)
		{
			alert("значение некорректно, введите значение между " + minimum + " и " + predel);
			input.focus();
			input.select();
		}
		var sem=document.getElementById("zachetsem"+num);
		var ekz=document.getElementById("zachet"+num);
		var hours=document.getElementById("zachethours"+num);
		if(sem.value!="" && ekz.value!="" && hours.value!="" )
		{
			$('#zachetpredmet'+(num+1)).show();
			$('#zachetsem'+(num+1)).focus();
		}
	}
	function checkIntKurs(minimum,predel,input,num)
	{
		if(isNaN(input.value) || input.value<minimum || input.value>predel)
		{
			alert("значение некорректно, введите значение между " + minimum + " и " + predel);
			input.focus();
			input.select();
		}
		var kurs=document.getElementById("kurs"+num);
		var hours=document.getElementById("kurshours"+num);
		if(kurs.value!="" && hours.value!="")
		{
			$('#kurspredmet'+(num+1)).show();
			$('#kurs'+(num+1)).focus();
		}
	}
	function rating(){
		for(i=1;i<8;i++)
		{
			var sem=document.getElementById("ekzsem"+i);
			var ekz=document.getElementById("ekz"+i);
			var hours=document.getElementById("ekzhours"+i);
			if(sem.value=="" && ekz.value=="" && hours.value=="")
			{
				break;
			}
			else if(sem.value!="" && ekz.value!="" && hours.value!="")
			{

			}
			else
			{
				alert('неверный ввод в строке '+i);
			}
		}
		var numEkz=i;
		var all_hours=0;
		for(j=1;j<numEkz;j++)
		{
			var hours=parseInt(document.getElementById("ekzhours"+j).value);
			all_hours=all_hours+hours;
		}
		for(i=1;i<8;i++)
		{
			var sem=document.getElementById("zachetsem"+i);
			var ekz=document.getElementById("zachet"+i);
			var hours=document.getElementById("zachethours"+i);
			if(sem.value=="" && ekz.value=="" && hours.value=="")
			{
				break;
			}
			else if(sem.value!="" && ekz.value!="" && hours.value!="")
			{

			}
			else
			{
				alert('неверный ввод в строке '+i);
			}
		}
		var numZachet=i;
		for(j=1;j<numZachet;j++)
		{
			var hours=parseInt(document.getElementById("zachethours"+j).value);
			all_hours=all_hours+hours;
		}
		for(i=1;i<8;i++)
		{
			var kurs=document.getElementById("kurs"+i);
			var hours=document.getElementById("kurshours"+i);
			if(kurs.value=="" && hours.value=="")
			{
				break;
			}
			else if(kurs.value!="" && hours.value!="")
			{

			}
			else
			{
				alert('неверный ввод в строке '+i);
			}
		}
		var numKurs=i;
		for(j=1;j<numKurs;j++)
		{
			var hours=parseInt(document.getElementById("kurshours"+j).value);
			all_hours=all_hours+hours;
		}
		var rating=0;
		for(j=1;j<numEkz;j++)
		{
			var sem=parseInt(document.getElementById("ekzsem"+j).value);
			var ekz=parseInt(document.getElementById("ekz"+j).value);
			var hours=parseInt(document.getElementById("ekzhours"+j).value);
			rating=rating+((sem+ekz)*hours)/(2*all_hours);
		}
		for(j=1;j<numZachet;j++)
		{
			var sem=parseInt(document.getElementById("zachetsem"+j).value);
			var ekz=parseInt(document.getElementById("zachet"+j).value);
			var hours=parseInt(document.getElementById("zachethours"+j).value);
			rating=rating+((sem+ekz)*hours)/(2*all_hours);
		}
		for(j=1;j<numKurs;j++)
		{
			var kurs=parseInt(document.getElementById("kurs"+j).value);
			var hours=parseInt(document.getElementById("kurshours"+j).value);
			rating=rating+(kurs*hours)/(all_hours);
		}
		//alert('Ваш рейтинг: '+rating+'\nсумма часов: '+all_hours);
		document.getElementById('rating_res').value = rating;
		$('#result').show();
		$('body, html').animate({scrollTop: 0}, 500);
	}
	$(document).ready(function(){
		$('#result').hide();
		$('#ekzpredmet2').hide();
		$('#ekzpredmet3').hide();
		$('#ekzpredmet4').hide();
		$('#ekzpredmet5').hide();
		$('#ekzpredmet6').hide();
		$('#ekzpredmet7').hide();
		$('#zachetpredmet2').hide();
		$('#zachetpredmet3').hide();
		$('#zachetpredmet4').hide();
		$('#zachetpredmet5').hide();
		$('#zachetpredmet6').hide();
		$('#zachetpredmet7').hide();
		$('#kurspredmet2').hide();
		$('#kurspredmet3').hide();
		$('#kurspredmet4').hide();
		$('#kurspredmet5').hide();
		$('#kurspredmet6').hide();
		$('#kurspredmet7').hide();
	});
</script>
<h1>Вычисление рейтинга:</h1>
<div id="result" class="alert alert-info">Ваш рейтинг:<input type="text" class="form-control" id="rating_res"/></div>
<form>
	<br/>
	<h2>Экзамены</h2>
	<table class="table">
		<tr>
			<td style="text-align: center">№</td>
			<td style="text-align: center">Баллы за семестр</td>
			<td style="text-align: center">Баллы за экзамен</td>
			<td style="text-align: center">Количество часов</td>
		</tr>
		<tr id="ekzpredmet1">
			<td>1</td>
			<td><input class="form-control" onchange="checkIntEkz(0,100,this,1)" id="ekzsem1"/></td>
			<td><input class="form-control" onchange="checkIntEkz(53,100,this,1)" id="ekz1"/></td>
			<td><input class="form-control" onchange="checkIntEkz(0,50000,this,1)" id="ekzhours1"/></td>
		</tr>
		<tr  id="ekzpredmet2">
			<td>2</td>
			<td><input class="form-control" onchange="checkIntEkz(0,100,this,2)" id="ekzsem2"/></td>
			<td><input class="form-control" onchange="checkIntEkz(53,100,this,2)" id="ekz2"/></td>
			<td><input class="form-control" onchange="checkIntEkz(0,50000,this,2)" id="ekzhours2"/></td>
		</tr>
		<tr id="ekzpredmet3">
			<td>3</td>
			<td><input class="form-control" onchange="checkIntEkz(0,100,this,3)" id="ekzsem3"/></td>
			<td><input class="form-control" onchange="checkIntEkz(53,100,this,3)" id="ekz3"/></td>
			<td><input class="form-control" onchange="checkIntEkz(0,50000,this,3)" id="ekzhours3"/></td>
		</tr>
		<tr id="ekzpredmet4">
			<td>4</td>
			<td><input class="form-control" onchange="checkIntEkz(0,100,this,4)" id="ekzsem4"/></td>
			<td><input class="form-control" onchange="checkIntEkz(53,100,this,4)" id="ekz4"/></td>
			<td><input class="form-control" onchange="checkIntEkz(0,50000,this,4)" id="ekzhours4"/></td>
		</tr>
		<tr id="ekzpredmet5">
			<td>5</td>
			<td><input class="form-control" onchange="checkIntEkz(0,100,this,5)" id="ekzsem5"/></td>
			<td><input class="form-control" onchange="checkIntEkz(53,100,this,5)" id="ekz5"/></td>
			<td><input class="form-control" onchange="checkIntEkz(0,50000,this,5)" id="ekzhours5"/></td>
		</tr>
		<tr id="ekzpredmet6">
			<td>6</td>
			<td><input class="form-control" onchange="checkIntEkz(0,100,this,6)" id="ekzsem6"/></td>
			<td><input class="form-control" onchange="checkIntEkz(53,100,this,6)" id="ekz6"/></td>
			<td><input class="form-control" onchange="checkIntEkz(0,50000,this,6)" id="ekzhours6"/></td>
		</tr>
		<tr id="ekzpredmet7">
			<td>7</td>
			<td><input class="form-control" onchange="checkIntEkz(0,100,this,7)" id="ekzsem7"/></td>
			<td><input class="form-control" onchange="checkIntEkz(53,100,this,7)" id="ekz7"/></td>
			<td><input class="form-control" onchange="checkIntEkz(0,50000,this,7)" id="ekzhours7"/></td>
		</tr>
	</table>
	<br/>
	<h2>Зачеты</h2>
	<table class="table">
		<tr>
			<td style="text-align: center">№</td>
			<td style="text-align: center">Баллы за семестр</td>
			<td style="text-align: center">Баллы за зачет</td>
			<td style="text-align: center">Количество часов</td>
		</tr>
		<tr id="zachetpredmet1">
			<td>1</td>
			<td><input class="form-control" onchange="checkIntZachet(0,100,this,1)" id="zachetsem1"/></td>
			<td><input class="form-control" onchange="checkIntZachet(53,100,this,1)" id="zachet1"/></td>
			<td><input class="form-control" onchange="checkIntZachet(0,50000,this,1)" id="zachethours1"/></td>
		</tr>
		<tr  id="zachetpredmet2">
			<td>2</td>
			<td><input class="form-control" onchange="checkIntZachet(0,100,this,2)" id="zachetsem2"/></td>
			<td><input class="form-control" onchange="checkIntZachet(53,100,this,2)" id="zachet2"/></td>
			<td><input class="form-control" onchange="checkIntZachet(0,50000,this,2)" id="zachethours2"/></td>
		</tr>
		<tr id="zachetpredmet3">
			<td>3</td>
			<td><input class="form-control" onchange="checkIntZachet(0,100,this,3)" id="zachetsem3"/></td>
			<td><input class="form-control" onchange="checkIntZachet(53,100,this,3)" id="zachet3"/></td>
			<td><input class="form-control" onchange="checkIntZachet(0,50000,this,3)" id="zachethours3"/></td>
		</tr>
		<tr id="zachetpredmet4">
			<td>4</td>
			<td><input class="form-control" onchange="checkIntZachet(0,100,this,4)" id="zachetsem4"/></td>
			<td><input class="form-control" onchange="checkIntZachet(53,100,this,4)" id="zachet4"/></td>
			<td><input class="form-control" onchange="checkIntZachet(0,50000,this,4)" id="zachethours4"/></td>
		</tr>
		<tr id="zachetpredmet5">
			<td>5</td>
			<td><input class="form-control" onchange="checkIntZachet(0,100,this,5)" id="zachetsem5"/></td>
			<td><input class="form-control" onchange="checkIntZachet(53,100,this,5)" id="zachet5"/></td>
			<td><input class="form-control" onchange="checkIntZachet(0,50000,this,5)" id="zachethours5"/></td>
		</tr>
		<tr id="zachetpredmet6">
			<td>6</td>
			<td><input class="form-control" onchange="checkIntZachet(0,100,this,6)" id="zachetsem6"/></td>
			<td><input class="form-control" onchange="checkIntZachet(53,100,this,6)" id="zachet6"/></td>
			<td><input class="form-control" onchange="checkIntZachet(0,50000,this,6)" id="zachethours6"/></td>
		</tr>
		<tr id="zachetpredmet7">
			<td>7</td>
			<td><input class="form-control" onchange="checkIntZachet(0,100,this,7)" id="zachetsem7"/></td>
			<td><input class="form-control" onchange="checkIntZachet(53,100,this,7)" id="zachet7"/></td>
			<td><input class="form-control" onchange="checkIntZachet(0,50000,this,7)" id="zachethours7"/></td>
		</tr>
	</table>
	<br/>
	<h2>Курсовые</h2>
	<table class='table'>
		<tr>
			<td style="text-align: center">№</td>
			<td style="text-align: center">Баллы</td>
			<td style="text-align: center">Количество часов</td>
		</tr>
		<tr id="kurspredmet1">
			<td>1</td>
			<td><input class="form-control" onchange="checkIntKurs(0,100,this,1)" id="kurs1"/></td>
			<td><input class="form-control" onchange="checkIntKurs(0,50000,this,1)" id="kurshours1"/></td>
		</tr>
		<tr  id="kurspredmet2">
			<td>2</td>
			<td><input class="form-control" onchange="checkIntKurs(0,100,this,2)" id="kurs2"/></td>
			<td><input class="form-control" onchange="checkIntKurs(0,50000,this,2)" id="kurshours2"/></td>
		</tr>
		<tr id="kurspredmet3">
			<td>3</td>
			<td><input class="form-control" onchange="checkIntKurs(0,100,this,3)" id="kurs3"/></td>
			<td><input class="form-control" onchange="checkIntKurs(0,50000,this,3)" id="kurshours3"/></td>
		</tr>
		<tr id="kurspredmet4">
			<td>4</td>
			<td><input class="form-control" onchange="checkIntKurs(0,100,this,4)" id="kurs4"/></td>
			<td><input class="form-control" onchange="checkIntKurs(0,50000,this,4)" id="kurshours4"/></td>
		</tr>
		<tr id="kurspredmet5">
			<td>5</td>
			<td><input class="form-control" onchange="checkIntKurs(0,100,this,5)" id="kurs5"/></td>
			<td><input class="form-control" onchange="checkIntKurs(0,50000,this,5)" id="kurshours5"/></td>
		</tr>
		<tr id="kurspredmet6">
			<td>6</td>
			<td><input class="form-control" onchange="checkIntKurs(0,100,this,6)" id="kurs6"/></td>
			<td><input class="form-control" onchange="checkIntKurs(0,50000,this,6)" id="kurshours6"/></td>
		</tr>
		<tr id="kurspredmet7">
			<td>7</td>
			<td><input class="form-control" onchange="checkIntKurs(0,100,this,7)" id="kurs7"/></td>
			<td><input class="form-control" onchange="checkIntKurs(0,50000,this,7)" id="kurshours7"/></td>
		</tr>
	</table>
	<br/>
	<input type="button" value="Посчитать" onclick="rating()" class="btn btn-primary" />
</form>

<? require($_SERVER['DOCUMENT_ROOT']."/include/footer.php"); ?>