<?php
//   __ _       _   _____ _ _      _    _           _   
//  / _| |     | | |  ___(_) |    | |  | |         | |  
// | |_| | __ _| |_| |__  _| | ___| |__| | ___  ___| |_ 
// |  _| |/ _` | __|  __|| | |/ _ \  __  |/ _ \/ __| __|
// | | | | (_| | |_| |   | | |  __/ |  | | (_) \__ \ |_ 
// |_| |_|\__,_|\__|_|   |_|_|\___|_|  |_|\___/|___/\__|
// by Jim (www.j-fx.ws)                   version 1.15.0
////////////////////////////////////////////////////////

$scripturl = "http://files.student48.ru/";
//// the URL to this script with a trailing slash

$adminpass = "lgtu4ever)";
//// set this password to something other than default
//// it will be used to access the admin panel

$maxfilesize = 256;
//// the maximum file size allowed to be uploaded (in megabytes)

$downloadtimelimit = 1;
//// time users must wait before downloading another file (in minutes)

$uploadtimelimit = 1;
//// time users must wait before uploading another file (in minutes)

$nolimitsize = 64;
//// if a file is under this many megabytes, there is no time limit

$deleteafter = 365;
//// delete files if not downloaded after this many days

$downloadtimer = 1;
//// length of the timer on the download page (in seconds)

$enable_filelist = false;
//// allows users to see a list of uploaded files. set to false to disable

//$allowedtypes = array("txt","gif","jpg","jpeg");
//// remove the //'s from the above line to enable file extention blocking
//// only file extentions that are noted in the above array will be allowed

$emailoption = false;
//// set this to true to allow users to email themselves the download links

$passwordoption = false;
//// set this to true to allow users to password protect their uploads

$descriptionoption = false;
//// set this to true to disable the description field

//$categories = array("Documents","Applications","Audio","Misc");
//// remove the //'s from the above line to enable categories
//// Users will be able to choose from this list of categories

setlocale(LC_ALL, 'en_US.UTF8');

?>