<?
	include('parts/settings.php');
	if(isset($_POST['uid']))
	{
		$err="<b>�� ��������� ���� ��� ������ ������� �������:</b>";
		if(isset($_POST['uid'])) $uid=$_POST['uid']; else{ $fail=true; $err.="<br>ID ���������";}
		$access=1;
		if(isset($_POST['first_name']) && trim($_POST['first_name'])!="") $first_name=_filter($_POST['first_name']); else{ $fail=true; $err.="<br>���";}
		if(isset($_POST['last_name']) && trim($_POST['last_name'])!="") $last_name=_filter($_POST['last_name']); else{ $fail=true; $err.="<br>�������";}
		if(isset($_POST['nick_name']) && trim($_POST['nick_name'])!="") $nick_name=_filter($_POST['nick_name']); else{ $fail=true; $err.="<br>���";}
		if(isset($_POST['photo'])) $photo=$_POST['photo']; else $photo="";
		if(isset($_POST['photo_rec'])) $photo_rec=$_POST['photo_rec']; else $photo_rec="";
		if(isset($_POST['sex'])) $sex=_filter($_POST['sex']); else{ $fail=true; $err.="<br>���";}
		if(filter_var($_POST['e_mail'],FILTER_VALIDATE_EMAIL)!=FALSE) $e_mail=_filter($_POST['e_mail']); else{ $fail=true; $err.="<br>E-mail";}
		$date_register=date("Y-m-d H:i:s"); 
		$messages=0;
		$rating=0;
		if(isset($_POST['hash']) && $_POST['hash']==md5("2010617".$uid."QtUffhhGku39y5LxoZNJ") && !$fail)
			$correct=true;
		elseif($_POST['hash']!=md5("2010617".$uid."QtUffhhGku39y5LxoZNJ"))
		{
			$err.="<br>�������� ID ���������";
			$fail=true;
		}
	}
	if($correct)
	{
		$query="INSERT INTO users VALUES('$uid', '$access', '$first_name', '$last_name', '$nick_name', '$photo', '$photo_rec', '$sex','$e_mail', '$date_register', '$messages', '$rating')";
		$result=mysql_query($query);
		mysql_close($dbconnect);
	}
	
?>

<html>
<head>
<title>����|������������ api ���������</title>
<? include('parts/head.php'); ?>
<?
	include ("VKapi.php" );

	$api_secret = "QtUffhhGku39y5LxoZNJ"; // �� �������� �������
	$api_id     = "2010617";              // id ������ ����������
	$api        = new VKapi($api_secret, $api_id);
?>

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
                <h1>���� ������:</h1>
                <? if(isset($_GET['uid']) || $fail): ?>
                <? if($fail)
						printf('<font color="#C30">%s</font>',$err);
				?>
                <table>
                	<form action="register.php" method="post">
                	<tr><td>Id ���������:</td><td>
					<? if(isset($_GET['uid'])) 
						printf('<input type="text" name="uid" value="%s" readonly>',$_GET['uid']); 
					elseif(isset($_POST['uid'])) 
						printf('<input type="text" name="uid" value="%s" readonly>',$_POST['uid']); 
					else 
						printf('<input type="text" name="uid">') ?></td></tr>
                    <tr><td>���:</td><td><? 
					if(isset($_GET['first_name'])) 
						printf('<input type="text" name="first_name" value="%s">',$_GET['first_name']);
					elseif(isset($_POST['first_name'])) 
						printf('<input type="text" name="first_name" value="%s">',$_POST['first_name']);
					else 
						printf('<input type="text" name="first_name">') ?></td></tr>
                    <tr><td>�������:</td><td><? 
					if(isset($_GET['last_name'])) 
						printf('<input type="text" name="last_name" value="%s">',$_GET['last_name']);
					elseif(isset($_POST['last_name'])) 
						printf('<input type="text" name="last_name" value="%s">',$_POST['last_name']); 
					else 
						printf('<input type="text" name="last_name">') ?></td></tr>
                    <tr><td>���:</td><td><? 
					if(isset($_POST['nick_name'])) 
						printf('<input type="text" name="nick_name" value="%s">',$_POST['nick_name']); 
					else 
						print('<input type="text" name="nick_name" value="">');?></td></tr>
                    <tr><td>���:</td><td><? 
					if(isset($_POST['sex'])) 
						if($sex==2)
							printf('<select name="sex"><option value="2" selected>�������</option><option value="1">�������</option></select>',$sex_select);
						else
							printf('<select name="sex"><option value="2">�������</option><option value="1" selected>�������</option></select>',$sex_select);
					else 
						printf('<select name="sex"><option value="2">�������</option><option value="1">�������</option></select>')?></td></tr>
                    <tr><td>E-mail:</td><td><? 
					if(isset($_POST['e_mail'])) 
						printf('<input type="text" name="e_mail" value="%s">',$_POST['e_mail']); 
					else 
						print('<input type="text" name="e_mail" value="">'); ?></td></tr>
					<?
                    if(isset($_GET['photo'])) 
						printf('<input type="hidden" name="photo" value="%s" readonly>',$_GET['photo']);
					elseif(isset($_POST['photo'])) 
						printf('<input type="hidden" name="photo" value="%s" readonly>',$_POST['photo']);
					if(isset($_GET['photo_rec'])) 
						printf('<input type="hidden" name="photo_rec" value="%s" readonly>',$_GET['photo_rec']); 
					elseif(isset($_POST['photo_rec'])) 
						printf('<input type="hidden" name="photo_rec" value="%s" readonly>',$_POST['photo_rec']);
					if(isset($_GET['hash'])) 
						printf('<input type="hidden" name="hash" value="%s" readonly>',$_GET['hash']); 
					elseif(isset($_POST['hash'])) 
						printf('<input type="hidden" name="hash" value="%s" readonly>',$_POST['hash']); ?>
                    <tr><td colspan="2"><input type="submit" value="�����������!"></td></tr>
                    </form>
                </table>

                <? elseif($correct): ?>
                	<h2>�����������, �� ����������������! </h2>
                    ���� ��������: <? printf("<a href='user.php?uid=%s'>%s</a>",$uid,$nick_name); ?>
                    
        		<? elseif(!isset($_GET['uid']) && !isset($_POST['uid'])): ?>
                	<h3><center> ��������� ������ �����, �������� �� �� �������������� ��������� </center></h3>
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