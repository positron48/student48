			<div id="footer">
				<hr>
				<center>
					<footer>
						<p>© Lipetsk 2010 - 2015</p>
					</footer>
				</center>

				<?if($_SERVER['SCRIPT_NAME'] == '/materials/index.php') {?>
					<script src="/js/materials.js"></script>
				<?}?>
				<?if($_SERVER['SCRIPT_NAME'] == '/questbook/index.php') {?>
					<script src="/js/questbook.js"></script>
				<?}?>
				<?if($_SERVER['SCRIPT_NAME'] == '/map.php') {?>
					<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
					<script src="/js/map.js"></script>
				<?}?>
				<?if($_SERVER['SCRIPT_NAME'] == '/files/index.php') {?>
					<script src="/js/files.js"></script>
				<?}?>
				<?if($_SERVER['SCRIPT_NAME'] == '/upload.php') {?>
					<script src="/js/upload.js"></script>
				<?}?>
				<?if($_SERVER['SCRIPT_NAME'] == '/admin/moderation.php') {?>
					<script src="/js/moderation.js"></script>
				<?}?>

			</div>    
		</div>
	</body>
</html>

<? $dbWorker = true; ?>