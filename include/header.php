    <nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="/"><b>student48.ru</b></a>
				</div>
				
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li <?=($_SERVER['SCRIPT_NAME']==='/index.php' || $_SERVER['SCRIPT_NAME']==='/new/index.php'?'class="active"':'')?>>
							<a href="/">Главная <span class="sr-only">(current)</span></a>
						</li>
						<li <?=($_SERVER['REQUEST_URI']==='/news/'?'class="active"':'')?>>
							<a href="/news/">Новости</a>
						</li>
						<li <?=($_SERVER['REQUEST_URI']==='/materials/'?'class="active"':'')?>>
							<a href="/materials/">Материалы</a>
						</li>
						<li <?=($_SERVER['REQUEST_URI']==='/questbook/'?'class="active"':'')?>>
							<a href="/questbook/">Гостевая</a>
						</li>
						<li <?=($_SERVER['REQUEST_URI']==='/files/'?'class="active"':'')?>>
							<a href="/files/">Обменник</a>
						</li>

						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Еще <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="/upload/">Добавить</a></li>
								<li><a href="/shpora/">Шпоры</a></li>
								<li><a href="/rating/">Рейтинг</a></li>
								<li><a href="/map/">Карта</a></li>
								<li><a href="/links/">Ссылки</a></li>
								<li><a href="https://vk.com/student48ru">ВКонтакте</a></li>
							</ul>
						</li>
					</ul>
					
					<ul class="nav navbar-nav navbar-right">
						<form class="navbar-form navbar-left" role="search">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Поиск материалов">
							</div>
							<button type="submit" class="btn btn-default">
								<center><span class="glyphicon glyphicon-search" style="height: 20px;"></span></center>
							</button>
						</form>
					</ul>
				</div>
			</div>
		</nav>
    <div class="container">