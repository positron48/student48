<? require('settings.php'); ?>
<? require('database.php'); ?>
<?
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
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="SHORTCUT ICON" href="/favicon.ico" type="image/x-icon">
		<link rel="stylesheet" href="/css/bootstrap.css">
		<link rel="stylesheet" href="/css/style.css">
		<script src="/js/jquery.js"></script>
		<script src="/js/jquery.form.js"></script>
		<script src="/js/bootstrap.js"></script>