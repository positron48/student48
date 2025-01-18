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

<div class="modal fade in" id="jaUstal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: block; padding-right: 17px;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="https://www.meme-arsenal.com/memes/2299aec4d781d59e8659eb6012f83947.jpg" style="
    margin: 25px auto;
    display: block;
">
<p>Друзья! Вот и канули в лету 9 лет существования проекта. Надеюсь, все это время сайт был не бесполезен и материалы кому-то пригодились.</p>
<p>К сожалению, более не располагаю возможностью поддерживать сайт. Знаю, что многие до сих пор сюда заходят - <b>Удачи</b> вам во всех начинаниях.</p>
<p>1 ноября заканчивается срок действия домена.</p>
<br>
<p>P.S. Если вдруг кому-то было бы интересно поддерживать сайт далее - <a href="mailto:positron48@gmail.com">напишите</a> мне.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
        
      </div>
    </div>
  </div>
</div>

<script> 
$(document).ready(function(){ 
    $('#jaUstal').modal();
})
</script>
	</body>
</html>

<? $dbWorker = true; ?>
