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

$bans=file("./bans.txt");
foreach($bans as $line)
{
  if ($line==$_SERVER['REMOTE_ADDR']){
    echo "Вам не разрешено скачивать файлы.";
    include("./footer.php");
    die();
  }
}

if(!isset($_GET['a']) || !isset($_GET['b']))
{
  echo "<script>window.location = '".$scripturl."';</script>";
}

$validdownload = 0;

$checkfiles=file("./files.txt");
$foundfile=0;
foreach($checkfiles as $line)
{
  $thisline = explode('|', $line);
  if ($thisline[0]==$_GET['a'] && md5($thisline[2].$_SERVER['REMOTE_ADDR'])==$_GET['b'])
    $validdownload=$thisline;
}

if($validdownload==0) {
    echo "Неправильная ссылка!";
    include("./footer.php");
    die();
}

$userip = $_SERVER['REMOTE_ADDR'];
$time = time();

$filesize = filesize("./storage/".$validdownload[0]);
$filesize = $filesize / 1048576;

if($filesize > $nolimitsize) {
$downloaders = fopen("./downloaders.txt","a+");
fputs($downloaders,"$userip|$time\n");
fclose($downloaders);
}

$validdownload[4] = time();

$fc=file("./files.txt");
$f=fopen("./files.txt","w");
foreach($fc as $line)
{
  $thisline = explode('|', $line);
  if ($thisline[0]!=$_GET['a'])
    fputs($f,$line);
  else
    fputs($f,$validdownload[0]."|". $validdownload[1]."|". $validdownload[2]."|". $validdownload[3]."|". $validdownload[4]."|".($validdownload[5]+1)."|".$validdownload[6]."|".$validdownload[7]."|".$validdownload[8]."|\n");
}
fclose($f);

header('Content-type: application/octetstream');
header('Content-Length: ' . filesize("./storage/".$validdownload[0]));
header('Content-Disposition: attachment; filename="'.$validdownload[1].'"');
readfile("./storage/".$validdownload[0]);

?>