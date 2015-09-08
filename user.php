<?
	include('parts/settings.php');
	if(isset($_GET['uid']))
	{
		$uid=$_GET['uid'];
		$dbdata=mysql_query("SELECT * FROM users WHERE uid=$uid", $dbconnect);
		$pagedata=mysql_fetch_array($dbdata);
	}
?>
<html>
<head>
<title>
<? 
	$title="ЛГТУ| ".$pagedata['nick_name'];
	printf("%s",$title)
?>
</title>
<? include('parts/head.php'); ?>
</head>
<body>

<div id="outer" align="center"> 
	<? include("parts/top.php"); ?>
    <div id="inner" align="left">
    	<div id="header">
        	<? include('parts/header.php'); ?>
        </div>
        <table cellpadding="0" cellspacing="0">
            <tr>
            	<td id="left">
                	<? include('parts/left.php'); ?>
                </td>
                <td id="main">
                	<h2>Информация о пользователе:</h2>
                    <? if(isset($_GET['uid']) && isset($_GET['uid'])>0): ?>
                    <table class="info_file" cellpadding="0" cellspacing="0">
                    	
                        <tr><td rowspan="6"><? printf('<img src="%s" />',$pagedata['photo_rec']); ?></td>
                        <td class=""><b>Ник: </b></td><td class=""> <? printf("%s",$pagedata['nick_name']) ?></td></tr>
                        <tr><td class=""><b>Имя: </b></td><td class=""> <? printf("%s",$pagedata['first_name']) ?></td></tr>
                        <tr><td class=""><b>Фамилия: </b></td><td class=""> <? printf("%s",$pagedata['last_name']) ?></td></tr>
                        <tr><td class=""><b>Пол: </b></td><td class=""> <? printf("%s",$pagedata['sex']) ?></td></tr>
                        <tr><td class=""><b>Е-mail: </b></td><td class=""> <? printf("%s",$pagedata['e_mail']) ?></td></tr>
                        <tr><td class=""><b>Дата регистрации: </b></td><td class=""> <? printf("%s",$pagedata['date_register']) ?></td></tr>
                    </table>
                    <? else: ?>
                    	<h3> Ошибка входа: возможно, вы уже зарегистрированы </h3>
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