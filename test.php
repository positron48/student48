<!DOCTYPE html>
<html>
<head>
<title>ЛГТУ|Мы переехали</title>
<? include('parts/head.php'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head>
<body>

	<? include("parts/top.php"); ?>
   	<? include('parts/header.php'); ?>
`   <div class="container">
                	<?
                    if($check)
                    {
						print __FILE__;
                    	printf('<br>$_SERVER["DOCUMENT_ROOT"]=%s',$_SERVER['DOCUMENT_ROOT']);
						printf('<br>$_SERVER["HTTP_HOST"]=%s',$_SERVER['HTTP_HOST']);
						printf('<br>$_SERVER["SERVER_NAME"]=%s',$_SERVER['SERVER_NAME']);
						printf('<br>$_SERVER["SCRIPT_FILENAME"]=%s',$_SERVER['SCRIPT_FILENAME']);
						printf('<br>$_SERVER["PHP_SELF"]=%s',$_SERVER['PHP_SELF']);
						printf('<br>$_SERVER["SCRIPT_NAME"]=%s',$_SERVER['SCRIPT_NAME']);
						printf('<br>$_SERVER["REQUEST_URI"]=%s',$_SERVER['REQUEST_URI']);
						printf('<br>$_SERVER["QUERY_STRING"]=%s',$_SERVER['QUERY_STRING']);
						printf('<br>$_SERVER["REQUEST_METHOD"]=%s',$_SERVER['REQUEST_METHOD']);
						printf('<br>$_SERVER["HTTP_REFERER"]=%s',$_SERVER['HTTP_REFERER']);
						printf('<br>$_SERVER["HTTP_USER_AGENT"]=%s',$_SERVER['HTTP_USER_AGENT']);
						printf('<br>$_SERVER["REMOTE_ADDR"]=%s',$_SERVER['REMOTE_ADDR']);
						printf('<br>$_SERVER["HTTP_ACCEPT"]=%s',$_SERVER['HTTP_ACCEPT']);
						printf('<br>$_SERVER["SERVER_ADDR"]=%s',$_SERVER['SERVER_ADDR']);
						printf('<br>$_SERVER["HTTP_ACCEPT_LANGUAGE"]=%s',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
						printf('<br>$_SERVER["HTTP_ACCEPT_CHARSET"]=%s',$_SERVER['HTTP_ACCEPT_CHARSET']);
						printf('<br>$_SERVER["HTTP_ACCEPT_ENCODING"]=%s',$_SERVER['HTTP_ACCEPT_ENCODING']);
						printf('<br>$_SERVER["SERVER_PORT"]=%s',$_SERVER['SERVER_PORT']);
						printf('<br>$_SERVER["SERVER_SOFTWARE"]=%s',$_SERVER['SERVER_SOFTWARE']);
						printf('<br>$_SERVER["SERVER_PROTOCOL"]=%s',$_SERVER['SERVER_PROTOCOL']);
						printf('<br>$_SERVER["GATEWAY_INTERFACE"]=%s',$_SERVER['GATEWAY_INTERFACE']);
						printf('<br>$_SERVER["REQUEST_TIME"]=%s',$_SERVER['REQUEST_TIME']);
                    }
                    else
                        printf("<div class='alert alert-danger'>У вас нет прав для доступа к служебной информации</div>");
					?>
                
    		<? include('parts/footer.php'); ?>

</div>

</body>
</html>