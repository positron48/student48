    <nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="<?='http://'.$_SERVER['SERVER_NAME']?>">Student48.ru</a>
				</div>
				
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li class="active"><a href="#">Главная <span class="sr-only">(current)</span></a></li>
						<li><a href="<?='http://'.$_SERVER['SERVER_NAME']?>/news/">Новости</a></li>
						<li><a href="<?='http://'.$_SERVER['SERVER_NAME']?>/materials/">Материалы</a></li>
						<li><a href="<?='http://'.$_SERVER['SERVER_NAME']?>/questbook/">Гостевая</a></li>
						<li><a href="<?='http://'.$_SERVER['SERVER_NAME']?>/files/">Обменник</a></li>

						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Еще <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="<?='http://'.$_SERVER['SERVER_NAME']?>/upload/">Добавить</a></li>
								<li><a href="<?='http://'.$_SERVER['SERVER_NAME']?>/shpora/">Шпоры</a></li>
								<li><a href="<?='http://'.$_SERVER['SERVER_NAME']?>/rating/">Рейтинг</a></li>
								<li><a href="<?='http://'.$_SERVER['SERVER_NAME']?>/contacts/">Контакты</a></li>
								<li><a href="<?='http://'.$_SERVER['SERVER_NAME']?>/map/">Карта</a></li>
								<li><a href="<?='http://'.$_SERVER['SERVER_NAME']?>/links/">Ссылки</a></li>
								<li><a href="http://vk.com/student48ru">ВКонтакте</a></li>
							</ul>
						</li>
					</ul>
					
					<ul class="nav navbar-nav navbar-right">
						<form class="navbar-form navbar-left" role="search">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Поиск материалов">
							</div>
							<button type="submit" class="btn btn-default">
								<center><span class="glyphicon glyphicon-search"></span></center>
							</button>
						</form>
					</ul>
				</div>
			</div>
		</nav>
    <div class="container">