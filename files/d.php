<!DOCTYPE html>
<html>
<head>
<title>ЛГТУ|Скачать</title>
<? 
include('../parts/head.php'); 
include("./config.php");
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head>
<?
	$_GET['f'] = base_convert($_GET['f'], 36, 16);
	if(isset($_GET['f'])) 
	{
		$filecrc = $_GET['f'];
	}
	$checkfiles=file("./files.txt");
	$foundfile=0;
	foreach($checkfiles as $line)
	{
	  $thisline = explode('|', $line);
	  if ($thisline[0]==$filecrc){
		$foundfile=$thisline;
	  }
	}
 ?>
<meta http-equiv="Refresh" content="1; URL=<? 	printf("%s","" .$scripturl. "download2.php?a=" . $filecrc . "&b=" . md5($foundfile[2].$_SERVER['REMOTE_ADDR'])); ?>">
<body>

 
	<? include("../parts/top.php"); ?>
    <? include('../parts/header.php'); ?>
    <div class="container">
	<?php


        $bans=file("./bans.txt");
        foreach($bans as $line)
        {
          if ($line==$_SERVER['REMOTE_ADDR']){
            echo "Вам не доступно скачивание файлов.";
            include("./footer.php");
            die();
          }
        }
        
        if(isset($_GET['f'])) {
          $filecrc = $_GET['f'];
        } else {
          echo "Неправильная ссылка!<br />";
          include("./footer.php");
          die();
        }
        
        $checkfiles=file("./files.txt");
        $foundfile=0;
        foreach($checkfiles as $line)
        {
          $thisline = explode('|', $line);
          if ($thisline[0]==$filecrc){
            $foundfile=$thisline;
          }
        }
        
        if(isset($_GET['del'])) {
        
        $fc=file("./files.txt");
        $f=fopen("./files.txt","w");
        $deleted=0;
        foreach($fc as $line)
        {
          $thisline = explode('|', $line);
          if ($thisline[0] == $_GET['f']){
            if($thisline[2] == $_GET['del']){
        	$deleted=1;
            } else {
            fputs($f,$line);
            }
          } else {
            fputs($f,$line);
          }
        }
        fclose($f);
        if($deleted==1){
        unlink("./storage/".$_GET['f']);
        echo "Ваш файл был удален.<br />";
        } else {
        echo "Неправильная ссылка для удаления.<br />";
        }
        include("./footer.php");
        die();
        
        }
        
        if($foundfile==0) {
          echo "Неправильная ссылка!<br />";
          include("./footer.php");
          die();
        }
        
        if(isset($foundfile[7]) && $foundfile[7]!=md5("") && (!isset($_POST['pass']) || $foundfile[7] != md5($_POST['pass']))){
        echo "<form action=\"download.php?file=".$foundfile[0]."\" method=\"post\">Введите пароль: <input type=\"password\" name=\"pass\"><input type=\"submit\" /></form>";
        include("./footer.php");
        die();
        }
        
        $filesize = filesize("./storage/".$foundfile[0]);
        $filesize = $filesize / 1048576;
        
        if($filesize > $nolimitsize) {
        
        $userip=$_SERVER['REMOTE_ADDR'];
        $time=time();
        $downloaders = fopen("./downloaders.txt","r+");
        flock($downloaders,2);
        while (!feof($downloaders)) { 
        $user[] = chop(fgets($downloaders,65536));
        }
        fseek($downloaders,0,SEEK_SET);
        ftruncate($downloaders,0);
        foreach ($user as $line) {
        list($savedip,$savedtime) = explode("|",$line);
        if ($savedip == $userip) {
        if ($time < $savedtime + ($downloadtimelimit*60)) {
        echo "Вы пытались скачать файл слишком рано!";
        include("./footer.php");
        die();
        }
        }
        if ($time < $savedtime + ($downloadtimelimit*60)) {
          fputs($downloaders,"$savedip|$savedtime\n");
        }
        }
        
        }

        echo "<h1>".$foundfile[1]." - ".round($filesize,2)." MB</h1>";
        if(isset($foundfile[6])){ echo "".$foundfile[6].""; }
        $randcounter = rand(100,999);
        ?>
<div id="dl" align="center">

<?php 
if($downloadtimer == 0) {
echo "<h4>Если скачивание не началось автоматически, перейдите по ссылке:</h4><a href=\"" .$scripturl. "download2.php?a=" . $filecrc . "&b=" . md5($foundfile[2].$_SERVER['REMOTE_ADDR']) . "\">Скачать</a>";
} else { ?>
Если Вы видите данное сообещние, Вам необходимо включить JavaScript в браузере!
<?php } ?>
</div>
<script language="Javascript">
x<?php echo $randcounter; ?>=<?php echo $downloadtimer; ?>;
function countdown() 
{
 if ((0 <= 100) || (0 > 0))
 {
  x<?php echo $randcounter; ?>--;
  if(x<?php echo $randcounter; ?> == 0)
  {
   document.getElementById("dl").innerHTML = '<h4>Если скачивание не началось автоматически, перейдите по ссылке:</h4><a href="<?php echo $scripturl . "download2.php?a=" . $filecrc . "&b=" . md5($foundfile[2].$_SERVER['REMOTE_ADDR']) ?>"><h2>Скачать!</h2></a>';
  }
  if(x<?php echo $randcounter; ?> > 0)
  {
   document.getElementById("dl").innerHTML = 'Подождите <b>'+x<?php echo $randcounter; ?>+'</b> сек..';
   setTimeout('countdown()',1000);
  }
 }
}
countdown();
</script>

<a href="report.php?file=<?php echo $foundfile[0];?>">Пожаловаться на файл</a></p>
<?php
echo "";
include("./header.php");
include("./footer.php");
?>

<? include('../parts/footer.php'); ?>

</div>

</body>
</html>