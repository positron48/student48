    <h1>��������</h1>
    <br />
	<h3>����������� ������������������ �� <a href ="http://db.tt/JdB9YeS"><img src="http://files.student48.ru/dropbox.png" width="3%"><u>Dropbox.com</u></a> � ����������� ��� ����� �� 2�� ��� ������ �� �� ����������� :)</h3>
	<br />

	<form enctype="multipart/form-data" action="upload.php" id="form" method="post" onsubmit="a=document.getElementById('form').style;a.display='none';b=document.getElementById('part2').style;b.display='inline';">
	<table><tr><td>
	<strong>������������ ������:</strong> <?php echo $maxfilesize; ?> MB<br />
	</td></tr><td><?php echo $filetypes; ?>
	<input type="file" name="upfile" size="50" /><br />
	<?php if($emailoption) { ?></td></tr><td>Email Address: <input type="text" name="myemail" size="30" /> <i>(Optional)</i><br /><?php } ?>
	<?php if($descriptionoption) { ?></td></tr><td>File Description: <input type="text" name="descr" size="30" /> <i>(Optional)</i><br /><?php } ?>
	<?php if($passwordoption) { ?></td></tr><td>Password Protection: <input type="text" name="pprotect" size="30" /> <i>(Optional)</i><br /><?php } ?>
	</td></tr><td><?php if(isset($categorylist)) { echo $categorylist; } ?>
	</td></tr><td>�������� ����, �� ������������ � <a href="?page=tos">���������</a>. <input class="btn" type="submit" value="��������!" id="upload" /></form>
	<div id="part2" style="display: none;">���� ������� �����. ����������, ���������...</div>
	</td></tr><td><br /><br />���������� ������: <b><?php echo $fileshosted; ?></b> ������: <b><?php echo $sizehosted; ?></b> MB.
	</td></tr></table>
