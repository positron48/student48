<?
@error_reporting(E_NONE);
@ini_set('display_errors', false);
@ini_set('html_errors', false);
@ini_set('error_reporting', E_NONE);
?>
<!DOCTYPE html>
<html>
<head>
<title>ЛГТУ|Обменник</title>
<? include('../parts/head.php'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head>
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

//delete old files

$deleteseconds = time() - ($deleteafter * 24 * 60 * 60);



$fc=file("./files.txt");

$f=fopen("./files.txt","w");

foreach($fc as $line)

{

  $thisline = explode('|', $line);

  if ($thisline[4] > $deleteseconds)

    fputs($f,$line);

  else

    unlink("./storage/".$thisline[0]);

}

fclose($f);

//done deleting old files



$fileshosted=sizeof(file("./files.txt")); //get the # of files hosted



$sizehosted = 0; //get the storage size hosted

$handle = opendir("./storage/");

while($file = readdir($handle)) {

$sizehosted = $sizehosted + filesize ("./storage/".$file);

  if((is_dir("./storage/".$file.'/')) && ($file != '..')&&($file != '.'))

  {

  $sizehosted = $sizehosted + total_size("./storage/".$file.'/');

  }

}

$sizehosted = round($sizehosted/1024/1024,2);



if(isset($allowedtypes)){ //get allowed filetypes.

  $types = implode(", ", $allowedtypes);

  $filetypes = "<b>allowed file types:</b> ".$types."<br /><br />";

} else { $filetypes = ""; }



if(isset($categories)){ //get categories

  $categorylist = "Category: <select name=\"category\">";

  foreach($categories as $category){

    $categorylist .= "<option value=\"".$category."\">".$category."</option>";

  }

  $categorylist .= "</select><br />";

} else { $filetypes = ""; }



if(isset($_GET['page']))

  $p = $_GET['page'];

else

  $p = "0";



switch($p) {

case "tos": include("./pages/tos.php"); break;

case "faq": include("./pages/faq.php"); break;

default: include("./pages/upload.php"); break;

}

echo "<br>";
include("./header.php");
include("./footer.php");

?>

    		<? include('../parts/footer.php'); ?>

</div>

</body>
</html>