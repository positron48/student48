<?
	include('parts/settings.php');
	if(isset($_GET['id']))
	{
		$id=_filter($_GET['id']);
		$dbdata=mysql_query("SELECT title_material, metakey, link, filesize, downloads, dateadd, title_predmet, semestr FROM materials, predmets WHERE predmetid=predmets.id AND materials.id=$id", $dbconnect);
		$pagedata=mysql_fetch_array($dbdata);
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>
<? 
	$title="����|�������: ".$pagedata['title_material']." / ".$pagedata['title_predmet']." (".$pagedata['metakey'].")";
	printf("%s",$title)
?>
</title>
<? include('parts/head.php'); ?>
<meta http-equiv="Refresh" content="1; URL=<? printf('%s',$pagedata['link']); ?>">
<body>

<? include("parts/top.php"); ?>
<? include('parts/header.php'); ?>
<div class="container">
   	<h2>���������� � �����:</h2>
                    <table class="table table-striped table-bordered table-condensed">
                        <tr><td><b>��������: </b></td><td> <? printf("%s",$pagedata['title_material']) ?></td></tr>
                        <tr><td><b>�������: </b></td><td> <? printf("%s",$pagedata['title_predmet']) ?></td></tr>
                        <tr><td><b>���������: </b></td><td> <? printf("%s",$pagedata['dateadd']) ?></td></tr>
                        <tr><td><b>�������: </b></td><td> <? printf("%s",$pagedata['semestr']) ?></td></tr>
                        <tr><td><b>������: </b></td><td> <? printf("%s Kb",$pagedata['filesize']) ?></td></tr>
                        <tr><td><b>C������: </b></td><td> <? printf("%s",$pagedata['downloads']) ?></td></tr>
                    </table>
                	<h4>����� ��� ��� ������� ����, ������������, ����������, � ������ ���������:</h4>
					<p>1. ��� ���������, ������������� �� ����� �������� ��� ������������. �� ������������� ���������� � ������ ��������� ������������� ����� ��������������� �� �����. ���������� �� ������ �������� ����������� ������ � ������ ���������� ������ �� ������ ������.
                    <p>2. ��� �����, ������������� �� ������� ��������� �� ���������� �������, ���� �����, ������ �� ������� ����������� � ���, ��������������� ������ ��������� ������������� �����������.
                    <p>3. ��� ����� �� ������������� �������� ����� "AS IS" ("��� ����"), �.�. �� ��� ��������� ����������� ����� �� ���������� �� ��������������� �� �����.
                    <p>4. ��� ���������� ������� ������ ������� ���� �� ������ � �������� ����� "��������� ���".
					
                    
                	<center>
					  
                    <?
                    	printf('<h4>���� ���������� �� �������� �������������, ��������� �� ������:</h4><a href="%s" class="btn btn-link"><h3>�������</h3></a>',$pagedata['link']);
						$downloads=$pagedata['downloads']+1;
						mysql_query("UPDATE materials SET downloads='$downloads' WHERE id='$id'");
					?>
                    </center>
                    <? printf("<table><tr><td>
						<!-- Put this script tag to the place, where the Share button will be -->
						<script type='text/javascript'>
						document.write(VK.Share.button({
							url: '%s',
							title: '%s',
							description: '","http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"],$title);
							printf('<b>��������:</b> %s, <br /> <b>�������:</b> %s, <br /><b>���������:</b> %s, <b>�������:</b> %s,<br /> <b>������:</b> %s, Kb<br /> <b>C������:</b> %s.<br />'
							,$pagedata['title_material'],$pagedata['title_predmet'],$pagedata['dateadd'],$pagedata['semestr'],$pagedata['filesize'],$pagedata['downloads']);
							print("',
							noparse: false
						},{type: 'button', text: '���������'}));
						</script></td>");
					print('<td>
						<!-- Put this div tag to the place, where the Like block will be -->
						<div class="like"><div id="vk_like"></div></div>
						<script type="text/javascript">
						VK.Widgets.Like("vk_like", {type: "full"});
						</script>
					</td></tr></table>'); ?>
                    <br>
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
	</div>
    </center>
</div>

</body>
</html>