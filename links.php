<!DOCTYPE html>
<html>
<head>
<title>����|������</title>
<? include('parts/head.php'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251"></head>
<body>

<? include("parts/top.php"); ?>
<? include('parts/header.php'); ?>
<div class="container">
                	<h1>������:</h1>
			<p>����� ����������� ��������� �������� ������ �� ��������� �������, ��������� � �������� ��������������� ����������� �������������. 
			<p>��������� �� ������ ����� ���������, ��������� ������������� �� ��� ���. 
			<p>���� �� ������ ���������� ��� ������-������ �������� ��� ������ ��������� ���� ������, � ������ ����� �������� �� ������ �������� �����������.
                    <ul>
						<li><a href="http://www.stu.lipetsk.ru/">����������� ���� ����</a>
                        <li><a href="http://lgtu.info/">���� ������� ����� LGTU</a>
						<li><a href="http://uk-lgtu.fatal.ru">���� ���������� ���������</a>
						<li><a href="http://as-05-2.narod.ru">���� ������ ��-05-2</a>
						<li><a href="http://www.ai-01.narod.ru">���� ��-01 </a>
						<li><a href="http://pm-lgtu.ucoz.ru/">������������ ���� �� ����</a>
					</ul>
			<table><tr><td>
			<!-- Put this div tag to the place, where the Like block will be -->
				<div class="like"><div id="vk_like"></div></div>
				<script type="text/javascript">
					VK.Widgets.Like("vk_like", {type: "full"});
				</script>
			</td></tr></table>
			<center>
            <!-- Put this div tag to the place, where the Comments block will be -->
            <div id="vk_comments"></div>
            	<script type="text/javascript">
                	VK.Widgets.Comments("vk_comments", {limit: 10, width: "690"});
            	</script>
            </center>
                </td>
            </tr>
    		<? include('parts/footer.php'); ?>  
    </center>
</div>

</body>
</html>