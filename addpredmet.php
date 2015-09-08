<?
	include('parts/settings.php');
	if(isset($_POST['title_predmet']) && $check)
	{
		$title_predmet=_filter($_POST['title_predmet']);
		$title_predmet_english=_filter($_POST['title_predmet_english']);
        if($title_predmet=="")
            $err="Поле предмета не заполнено";
        if($title_predmet_english=="")
        {
            if($err!="")
                $err.="<br>";
            $err .= "Поле английское название не заполнено";
        }
		$semestr=_filter($_POST['semestr']);
        if(!$err)
        {
    		if(!is_dir("materials/semestr_".$semestr))
    		{
    			if(!mkdir("materials/semestr_".$semestr))
                    $err.="Папка для семестра не была создана";
    		}
    		//if(!is_dir("materials/semestr_".$semestr."/".$tiitle_predmet_english))
    		{
    			if(!mkdir("materials/semestr_".$semestr."/".$title_predmet_english))
                    $err.="Папка для семестра не была создана";
    		}		
    		$query="INSERT INTO predmets VALUES(NULL,'$title_predmet','$title_predmet_english','$semestr')";
    		$add=true;
        }
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>ЛГТУ|Добавление предмета</title>

<? include('parts/head.php'); ?>

<meta http-equiv="Content-Type" content="text/html; charset=windows-1251"></head>
<body>
<? include("parts/top.php"); ?>
<? include('parts/header.php'); ?>
<div class="container">
                <? if($check && !$add): ?>
                    <? if($err!="")
                        printf("<div class='alert alert-warning'> %s </div>", $err)?>
             		<p><h1>Добавьте предмет:</h1>
                    <form name="addnews" method="post" action="addpredmet.php">
                    	<table>
                        <tr>
                            <td>Название:</td><td><input type="text" name="title_predmet" size="83" <?if($title_predmet!="") printf("value='%s'",$title_predmet);?>/></td>
                        </tr>
                        <tr>
                            <td>Английское название:</td><td><input type="text" name="title_predmet_english" size="83" <?if($title_predmet!="") printf("value='%s'",$title_predmet_english);?> /></td>
                        </tr>
                        <tr>
                            <td>Семестр:</td>
                            <td>
                            	<select name="semestr">
                            		<option value="1" <?if($semestr==1) printf("selected='true'");?> >1</option>
                                    <option value="2" <?if($semestr==2) printf("selected='true'");?>>2</option>
                                    <option value="3" <?if($semestr==3) printf("selected='true'");?>>3</option>
                                    <option value="4" <?if($semestr==4) printf("selected='true'");?>>4</option>
                                    <option value="5" <?if($semestr==5) printf("selected='true'");?>>5</option>
                                    <option value="6" <?if($semestr==6) printf("selected='true'");?>>6</option>
                                    <option value="7" <?if($semestr==7) printf("selected='true'");?>>7</option>
                                    <option value="8" <?if($semestr==8) printf("selected='true'");?>>8</option>
                                    <option value="9" <?if($semestr==9) printf("selected='true'");?>>9</option>
                                    <option value="10" <?if($semestr==10) printf("selected='true'");?>>10</option>
                                </select>    
                            </td>
                       	</tr>
                        <tr><td colspan="2"> 
                            <input type="submit" value="Отправить" class="btn" /><input type="reset" value="Очистить" class="btn" />
                        </td></tr>
                        </table>
                	</form>
                <? elseif($add): ?>
				<?
                    $result=mysql_query($query);
					mysql_close($dbconnect);
					if(!$result)
					{
						printf("<div class='alert alert-error'>Ошибка при записи в базу данных</div>");
						
					}
					else
					{
							printf("<div class='alert alert-success'>Предмет добавлен!</div>");
					}    
				?>   
                <? else: ?>
                	<br><div class="alert alert-danger">У вас недостаточно прав для добавления предметов</div>   
                <? endif ?>      	
                
<? include('parts/footer.php'); ?>
</div>

</body>
</html>