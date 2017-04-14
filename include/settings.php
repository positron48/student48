<?
define('ADMIN_MAIL', 'positron48@gmail.com');

$countNewsOnPage = 10;
$countMaterialsOnStartPage = 20;
$countMaterialsOnPage = 30;
$countMessagesOnPage = 20;

session_start();
$isAdmin = false;
if(isset($_POST['login']) && isset($_POST['password']) && $_POST['login']=='admin'){
    $passwd = md5('student48_'.$_POST['login'].'_'.$_POST['password']);
    if($passwd === 'cb7c9c965f18b07876f216c1e53be0d3'){
        $_SESSION['isAdmin']=true;
    }
}
if(isset($_POST['logout']))
    unset($_SESSION['isAdmin']);

if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']===true)
    $isAdmin = true;