    <h1>Обменник</h1>
    <br />
	<h3>Рекомендуем зарегистрироваться на <a href ="http://db.tt/JdB9YeS"><img src="http://files.student48.ru/dropbox.png" width="3%"><u>Dropbox.com</u></a> и выкладывать там файлы до 2гб без опаски за их сохранность :)</h3>
	<br />

	<form enctype="multipart/form-data" action="upload.php" id="form" method="post" onsubmit="a=document.getElementById('form').style;a.display='none';b=document.getElementById('part2').style;b.display='inline';">
	<table><tr><td>
	<strong>Максимальный размер:</strong> <?php echo $maxfilesize; ?> MB<br />
	</td></tr><td><?php echo $filetypes; ?>
	<input type="file" name="upfile" size="50" /><br />
	<?php if($emailoption) { ?></td></tr><td>Email Address: <input type="text" name="myemail" size="30" /> <i>(Optional)</i><br /><?php } ?>
	<?php if($descriptionoption) { ?></td></tr><td>File Description: <input type="text" name="descr" size="30" /> <i>(Optional)</i><br /><?php } ?>
	<?php if($passwordoption) { ?></td></tr><td>Password Protection: <input type="text" name="pprotect" size="30" /> <i>(Optional)</i><br /><?php } ?>
	</td></tr><td><?php if(isset($categorylist)) { echo $categorylist; } ?>
	</td></tr><td>Загружая файл, вы соглашаетесь с <a href="?page=tos">правилами</a>. <input class="btn" type="submit" value="Закачать!" id="upload" /></form>
	<div id="part2" style="display: none;">Идет закачка файла. Пожалуйста, подождите...</div>
	</td></tr><td><br /><br />Количество файлов: <b><?php echo $fileshosted; ?></b> Размер: <b><?php echo $sizehosted; ?></b> MB.
	</td></tr></table>
