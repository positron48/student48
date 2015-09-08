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

if(isset($_GET['act'])){$act = $_GET['act'];}else{$act = "null";}

session_start();

?>

<!DOCTYPE html>
<html>
<head>
<title>ЛГТУ|Админка</title>
<? include('../parts/head.php'); ?>

</head>
<body>

	

<? include("../parts/top.php"); ?>
    <? include('../parts/header.php'); ?>
    <div class="container">
<?

if($act=="login"){

  if($_POST['passwordx']==$adminpass){

    $_SESSION['logged_in'] = md5(md5($adminpass));

  }

}

if($act=="logout"){

  session_unset();

  echo "Logged out.";

}



if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==md5(md5($adminpass))) {



if(isset($_GET['download'])){



$checkfiles=file("./files.txt");

foreach($checkfiles as $line){

  $thisline = explode('|', $line);

  if($thisline[0]==$_GET['download'])

    $downloadfile=$thisline;

}

echo "<script>window.location='".$scripturl."download2.php?a=".$downloadfile[0]."&b=".md5($downloadfile[2].$_SERVER['REMOTE_ADDR'])."';</script>";

}



if(isset($_GET['delete'])) {



$fc=file("./files.txt");

$f=fopen("./files.txt","w+");

foreach($fc as $line)

{

  $thisline = explode('|', $line);

  if ($thisline[0] != $_GET['delete'])

    fputs($f,$line);

}

fclose($f);

unlink("./storage/".$_GET['delete']);

}



if(isset($_GET['banreport'])) {



$fc=file("./files.txt");

$f=fopen("./files.txt","w+");

foreach($fc as $line)

{

  $thisline = explode('|', $line);

  if ($thisline[0] != $_GET['banreport'])

    fputs($f,$line);

  else

    $deleted=$thisline;

}

fclose($f);

$fc=file("./reports.txt");

$f=fopen("./reports.txt","w+");

foreach($fc as $line)

{

  $thisline = explode('|', $line);

  if ($thisline[0] != $_GET['banreport'])

    fputs($f,$line);

}

fclose($f);

$f=fopen("./bans.txt","a+");

fputs($f,$deleted[3]."\n".$deleted[0]."\n");

unlink("./storage/".$_GET['banreport']);

}



if(isset($_GET['ignore'])) {



$fc=file("./reports.txt");

$f=fopen("./reports.txt","w+");

foreach($fc as $line)

{

  $thisline = explode('|', $line);

  if ($thisline[0] != $_GET['ignore'])

    fputs($f,$line);

}

fclose($f);

}



if(isset($_GET['act']) && $_GET['act']=="bans") {



if(isset($_GET['unban'])) {

$fc=file("./bans.txt");

$f=fopen("./bans.txt","w+");

foreach($fc as $line)

{

  if (md5($line) != $_GET['unban'])

    fputs($f,$line);

}

fclose($f);

}



if(isset($_POST['banthis'])) {

$f=fopen("./bans.txt","a+");

fputs($f,$_POST['banthis']."\n");

}





?>

<h1>Bans</h1><p> <center><form class="form-inline" action="admin.php?act=bans" method="post">enter an ip or file hash to ban:  

<input type="text" name="banthis"> 

<input type="submit" class="btn" value="BAN!">

<br />

</form></center>

<?php



$fc=file("./bans.txt");

foreach($fc as $line)

{

  echo $line . " - <a href=\"admin.php?act=bans&unban=".md5($line)."\">unban</a><br />";

}





die();

}





?>

<center><a href="admin.php?act=logout">click here to log out</a> | <a href="admin.php?act=bans">click here to manage bans</a></center><br />



  <h1>Reports</h1>

<table width="100%" cellpadding="0" cellspacing="0" border="0">

<tr><td><b>filename</b></td><td><b>uploader</b></td><td><b>delete&ban</b></td><td><b>ignore report</b></td></tr>

<?php



$checkreports=file("./reports.txt");

foreach($checkreports as $line)

{

  $thisreport = explode('|', $line);

  $checkfiles=file("./files.txt");

  foreach($checkfiles as $line)

  {

    $thisline = explode('|', $line);

    if($thisline[0]==$thisreport[0]){

	$foundfile=$thisline;

    }

  }



echo "<tr><td><a href=\"admin.php?download=".$foundfile[0]."\">".$foundfile[1]."</td>";

echo "<td>".$foundfile[3]."</td>";

echo "<td><a href=\"admin.php?banreport=".$foundfile[0]."\">delete&ban</a></td>";

echo "<td><a href=\"admin.php?ignore=".$foundfile[0]."\">ignore report</a></td></tr>";



}



?>

</table>

<br />



  <h1>Files</h1>

<table width="100%" cellpadding="0" cellspacing="0" border="0">

<tr><td><b>filename</b></td><td><b>size (MB)</b></td><td><b>uploader</b></td><td><b>bandwidth(MB)</b></td><td><b>delete</b></td></tr>

<?php



$checkfiles=file("./files.txt");

foreach($checkfiles as $line)

{

  $thisline = explode('|', $line);

  $filesize = filesize("./storage/".$thisline[0]);

  $filesize = ($filesize / 1048576);

  echo "<tr><td><a href=\"admin.php?download=".$thisline[0]."\">".$thisline[1]."</td><td>".round($filesize,2)."</td>";

  echo "<td>".$thisline[3]."</td><td>".round($filesize*$thisline[5],2)."</td><td><a href=\"admin.php?delete=".$thisline[0]."\">delete</a></td></tr>";

}

echo "</table>";

} else {

?><center>

<h1>Admin Login</h1><br />

<form class="form-inline" action="admin.php?act=login" method="post">Password:  

<input type="text" name="passwordx"> 

<input type="submit" value="Login" class="btn">

<br /><br />

</form></center>

<?php }
echo "<br>";
include("./header.php");

?>
</td>
            </tr>
        </table>
	    <div id="footer">
    		<? include('../parts/footer.php'); ?>
        </div>    
	</div>
    </center>
</div>

</body>
</html>