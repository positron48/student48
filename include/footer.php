			<div id="footer">
				<hr>
				<center>
					<footer>
						<p>© Lipetsk 2010 - 2015</p>
					</footer>
				</center>
				<script src="http://<?=$_SERVER['SERVER_NAME']?>/js/jquery.js"></script>
				<script src="http://<?=$_SERVER['SERVER_NAME']?>/js/jquery.form.js"></script>
				<script src="http://<?=$_SERVER['SERVER_NAME']?>/js/bootstrap.js"></script>
				<?if($_SERVER['SCRIPT_NAME'] == '/materials/index.php') {?>
					<script src="http://<?=$_SERVER['SERVER_NAME']?>/js/materials.js"></script>
				<?}?>
				<?if($_SERVER['SCRIPT_NAME'] == '/questbook/index.php') {?>
					<script src="http://<?=$_SERVER['SERVER_NAME']?>/js/questbook.js"></script>
				<?}?>
				<?if($_SERVER['SCRIPT_NAME'] == '/map.php') {?>
					<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
					<script src="http://<?=$_SERVER['SERVER_NAME']?>/js/map.js"></script>
				<?}?>
			</div>    
		</div>
	</body>
</html>

<? $dbWorker = true; ?>