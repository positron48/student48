<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="http://student48.ru/">student48.ru</a>
            <div class="nav-collapse">
                <ul class="nav">
                    <li <? if(($_SERVER['PHP_SELF']=="/index.php") && ($_SERVER['HTTP_HOST']=="student48.ru") || ($_SERVER['HTTP_HOST']=="www.student48.ru"))	echo('class="active"'); ?>>
                        <a href="http://student48.ru/index.php">Главная</a>
                    </li>
                    <li <? if(($_SERVER['PHP_SELF']=="/news.php") && ($_SERVER['HTTP_HOST']=="student48.ru") || ($_SERVER['HTTP_HOST']=="www.student48.ru"))	echo('class="active"'); ?>>
                        <a href="http://student48.ru/news.php">Новости</a>
                    </li>
                    <li <? if(($_SERVER['PHP_SELF']=="/materials.php") && ($_SERVER['HTTP_HOST']=="student48.ru") || ($_SERVER['HTTP_HOST']=="www.student48.ru"))	echo('class="active"'); ?>>
                        <a href="http://student48.ru/materials.php">Материалы</a>
                    </li>
                    <li <? if(($_SERVER['PHP_SELF']=="/questbook.php") && ($_SERVER['HTTP_HOST']=="student48.ru") || ($_SERVER['HTTP_HOST']=="www.student48.ru"))	echo('class="active"'); ?>>
                        <a href="http://student48.ru/questbook.php">Гостевая</a>
                    </li>
                    <li <? if(($_SERVER['HTTP_HOST']=="files.student48.ru") || ($_SERVER['HTTP_HOST']=="www.files.student48.ru"))	echo('class="active"'); ?>>
                        <a href="http://files.student48.ru">Обменник</a>
                    </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                          Еще
                          <i class="caret"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="http://student48.ru/upload.php">Добавить</a></li>
                            <li><a href="http://student48.ru/shpora">Шпоры</a></li>
                            <li><a href="http://student48.ru/rating.php">Рейтинг</a></li>
                            <li><a href="http://student48.ru/contacts.php">Контакты</a></li>
                            <li><a href="http://student48.ru/map.php">Карта</a></li>
                            <li><a href="http://student48.ru/links.php">Ссылки</a></li>
                            <li><a href="http://vk.com/student48ru">ВКонтакте</a></li>
                        </ul>
                      </li>
                </ul>
                <form class="navbar-search pull-right" action="http://student48.ru/search.php" method="GET">
                    <button type="submit" class="btn btn-inverse pull-right" style="margin-top: 0px;">Поиск</button><input type="text" class="search-query span2" placeholder="Поиск материалов" name="search_text"></input>
                    
                </form>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>