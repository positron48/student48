<?
	include('parts/settings.php');
	if(isset($_POST['exit']) && $_POST['exit'] && $check)
	{
		unset($_SESSION['user']);
		unset($_SESSION['password']);	
		$check=false;	
	}
		
	if(isset($_POST['user']) && isset($_POST['password']) && !$check)
	{
		$try=true;
		$_SESSION['user']=$_POST['user'];
		$_SESSION['password']=$_POST['password'];
		if($_SESSION['password']=="$pass_admin" && $_SESSION['user']=="$name_admin")
		{
			$check=true;
			//header("Location: index.php");
		}
		else
			$enter=false;
	}		
?>
<!DOCTYPE html>
<html>
<head>
<title>ЛГТУ|Админка</title>
<? include('parts/head.php'); ?>
</head>
<body>

<? include("parts/top.php"); ?>
<? include('parts/header.php'); ?>
    <div class="container">
	   <h1>Админка</h1>
            <?
                if($check)
                    printf("<h3><font color='#00AA00'><center>Привет, %s</center></font></h3>",$_SESSION['user']);
    			elseif($try)
    				print("<h3><font color='#AA0000'><center>Неверное имя пользователя или пароль</center></font></h3>");
            ?>
            <? if(!$check): ?>
            <br />
            <div class="alert alert-info"> Для администрирования сайта необходим пароль доступа. По всем вопросам обращайтесь на почтовый ящик: <a href="mailto:positron48@gmail.com">positron48@gmail.com</a></div>
            <form action="admin.php" method="post">
                <table>
                    <tr><td>
                        Имя:</td><td> <input type="text" name="user">
                    </td></tr><tr><td>
                        Пароль: </td><td><input type="password" name="password">
                    </td></tr><tr><td colspan="2">
                        <input class="btn" type="submit" value="Вход">
                    </td></tr>
                </table>
            </form>
    		<? else: ?>
            	
            	<form action="admin.php" method="post">
               		<input type="hidden" name="exit" value="true">
               		<center><input type="submit" value="Выход" class="btn"> </center>
                </form>
               
                <a href="addnews.php">Добавить новость</a><br>
                <a href="update.php">Добавить материал</a><br>
                <a href="addpredmet.php">Добавить предмет</a><br>
                
                <a href="edit_news.php">Редактировать новость</a><br>
                <a href="edit_materials.php">Редактировать материал</a><br>
                <a href="edit_predmets.php">Редактировать предмет</a><br>
                
                <a href="moderation.php">Модерация</a><br>
            <? endif ?>
                    
                    
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