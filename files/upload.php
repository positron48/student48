<!DOCTYPE html>
<html>
<head>
<title>ЛГТУ|Загружено</title>
<? include('../parts/head.php'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251"></head>
<body>

 
	<? include("../parts/top.php"); ?>
    
    	
        	<? include('../parts/header.php'); ?>
        <div class="container">
<?php
//   __ _       _   _____ _ _      _    _           _   
//  / _| |     | | |  ___(_) |    | |  | |         | |  
// | |_| | __ _| |_| |__  _| | ___| |__| | ___  ___| |_ 
// |  _| |/ _` | __|  __|| | |/ _ \  __  |/ _ \/ __| __|
// | | | | (_| | |_| |   | | |  __/ |  | | (_) \__ \ |_ 
// |_| |_|\__,_|\__|_|   |_|_|\___|_|  |_|\___/|___/\__|
// by Jim (www.j-fx.ws)                   version 1.15.0
////////////////////////////////////////////////////////

include("./config.php");


$filename = $_FILES['upfile']['name'];
$filesize = $_FILES['upfile']['size'];
$filecrc = md5_file($_FILES['upfile']['tmp_name']);

$bans=file("./bans.txt");
foreach($bans as $line)
{
  if ($line==$filecrc."\n"){
    echo "That file is not allowed to be uploaded.";
    include("./footer.php");
    die();
  }
  if ($line==$_SERVER['REMOTE_ADDR']."\n"){
    echo "Вам не разрешено закачивать файлы.";
    include("./footer.php");
    die();
  }
}

$checkfiles=file("./files.txt");
foreach($checkfiles as $line)
{
  $thisline = explode('|', $line);
  if ($thisline[0]==$filecrc){
    echo "Этот файл уже был закачан.<br />";
    echo "Ссылка для скачивания: <textarea name='textarea' cols='74' wrap='soft' rows='1' onclick='this.select();'>" . $scripturl . "download.php?file=" . $filecrc . "</textarea><br /><br />";
    echo "Т.к. этот файл загружен кем-то еще, мы не можем дать Вам ссылку на удаление.<br /><br />";
    include("./footer.php");
    die();
  }
}

if(isset($allowedtypes)){
$allowed = 0;
foreach($allowedtypes as $ext) {
  if(substr($filename, (0 - (strlen($ext)+1) )) == ".".$ext)
    $allowed = 1;
}
if($allowed==0) {
   echo "That file type is not allowed to be uploaded.";
   include("./footer.php");
   die();
}
}

if(isset($categorylist)){
$validcat = 0;
foreach($categories as $cat) {
  if($_POST['category']==$cat || $_POST['category'] = ""){ $validcat = 1; }
}
if($validcat==0) {
   echo "Invalid category was chosen..";
   include("./footer.php");
   die();
}
$cat = $_POST['category'];
} else { $cat = ""; }

if($filesize==0) {
echo "Вы не выбрали файл для закачивания.";
include("./footer.php");
die();
}

$filesize = $filesize / 1048576;

if($filesize > $maxfilesize) {
echo "Размер файла слишком велик.";
include("./footer.php");
die();
}

$userip = $_SERVER['REMOTE_ADDR'];
$time = time();

if($filesize > $nolimitsize) {

$uploaders = fopen("./uploaders.txt","r+");
flock($uploaders,2);
while (!feof($uploaders)) { 
$user[] = chop(fgets($uploaders,65536));
}
fseek($uploaders,0,SEEK_SET);
ftruncate($uploaders,0);
foreach ($user as $line) {
@list($savedip,$savedtime) = explode("|",$line);
if ($savedip == $userip) {
if ($time < $savedtime + ($uploadtimelimit*60)) {
echo "Вы пытаетесь закачивать файлы слишком часто!";
include("./footer.php");
die();
}
}
if ($time < $savedtime + ($uploadtimelimit*60)) {
  fputs($uploaders,"$savedip|$savedtime\n");
}
}
fputs($uploaders,"$userip|$time\n");

}

$passkey = rand(100000, 999999);

if($emailoption && isset($_POST['myemail']) && $_POST['myemail']!="") {
$uploadmsg = "Ваш файл (".$filename.") был загружен.\n Ссылка для скачивания: ". $scripturl . "download.php?file=" . $filecrc . "\n Ссылка для удаления: ". $scripturl . "download.php?file=" . $filecrc . "&del=" . $passkey . "\n Спасибо за использование нашего сайта!";
mail($_POST['myemail'],"Ваш загруженный файл",$uploadmsg,"От: support@student48.ru\n");
}

if($passwordoption && isset($_POST['pprotect'])) {
  $passwerd = md5($_POST['pprotect']);
} else { $passwerd = md5(""); }

if($descriptionoption && isset($_POST['descr'])) {
  $description = strip_tags($_POST['descr']);
} else { $description = ""; }

$filelist = fopen("./files.txt","a+");
fwrite($filelist, $filecrc ."|". basename($_FILES['upfile']['name']) ."|". $passkey ."|". $userip ."|". $time."|0|".$description."|".$passwerd."|".$cat."|\n");

$movefile = "./storage/" . $filecrc;
move_uploaded_file($_FILES['upfile']['tmp_name'], $movefile);

echo "Ваш файл был загружен!<br />";
// echo "Короткая ссылка: <textarea name='textarea' cols='74' wrap='soft' rows='1' onclick='this.select();'>" . $scripturl . "d.php?f=" . base_convert($filecrc, 16, 36) . "</textarea><br /><br />";
echo "Ссылка для скачивания: <textarea name='textarea' cols='74' wrap='soft' rows='1' onclick='this.select();'>" . $scripturl . "download.php?file=" . $filecrc . "</textarea><br /><br />";
echo "Ссылка для удаления: <textarea name='textarea' cols='74' wrap='soft' rows='1' onclick='this.select();'>" . $scripturl . "download.php?file=" . $filecrc . "&del=" . $passkey . "</textarea><br /><br />";
echo "Спасибо за использование нашего сайта!";
echo "<br>";
include("./header.php");
include("./footer.php");
?>

    		<? include('../parts/footer.php'); ?>
    
</div>

</body>
</html>