<!DOCTYPE html>
<html>
<head>
<title>ЛГТУ|Отчет</title>
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





if(isset($_GET['file'])){

$thisfile=$_GET['file'];

}else{

echo "Try reporting a file."; 

include("./footer.php");

die();

}



$checkfiles=file("./files.txt");

$foundfile=0;

foreach($checkfiles as $line)

{

  $thisline = explode('|', $line);

  if ($thisline[0]==$thisfile){

    $foundfile=1;

  }

}

if($foundfile==0){

echo "Try reporting a file."; 

include("./footer.php");

die();

}



$bans=file("./bans.txt");

foreach($bans as $line)

{

  if ($line==$_SERVER['REMOTE_ADDR']."\n"){

    echo "You are not allowed to report files.";

    include("./footer.php");

    die();

  }

}



$reported = 0;

$fc=file("./reports.txt");

foreach($fc as $line)

{

  $thisline = explode('|', $line);

  if ($thisline[0] == $thisfile)

    $reported = 1;

}



if($reported == 1) {

echo "Заявка была отправлена, спасибо.";

include("./footer.php");

die();

}



$filelist = fopen("./reports.txt","a+");

fwrite($filelist, $thisfile ."|". $_SERVER['REMOTE_ADDR'] ."\n");



echo "Заявка была отправлена, спасибо.";

echo "<br>";
include("./header.php");
include("./footer.php");



?>
    		<? include('../parts/footer.php'); ?>
    
</div>

</body>
</html>