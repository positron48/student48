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
				<?if($_SERVER['SCRIPT_NAME'] == '/admin/predmets.php') {?>
					<script src="/js/predmets.js"></script>
				<?}?>
				<?if($_SERVER['SCRIPT_NAME'] == '/admin/news.php') {?>
					<script src="/js/news.js"></script>
				<?}?>
			</div>    
		</div>

		<script src="/js/jquery.form.js"></script>
		<script src="/js/bootstrap.js"></script>
		<script src="/js/search.js"></script>
		<link rel="stylesheet" href="/css/style.css">


		<script>
			  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			  ga('create', 'UA-23307074-1', 'auto');
			  ga('send', 'pageview');
		</script>
	</body>
</html>

<? $dbWorker = true; ?>