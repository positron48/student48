<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="#">student48.ru</a>
            <div class="btn-group pull-right">
                <button class="btn btn-inverse">�����</button>
            </div>
            <div class="nav-collapse">
                <ul class="nav">
                    <li <? if(($_SERVER['PHP_SELF']=="/index.php") && ($_SERVER['HTTP_HOST']=="student48.ru") || ($_SERVER['HTTP_HOST']=="www.student48.ru"))	echo('class="active"'); ?>>
                        <a href="index.php">�������</a>
                    </li>
                    <li <? if(($_SERVER['PHP_SELF']=="/news.php") && ($_SERVER['HTTP_HOST']=="student48.ru") || ($_SERVER['HTTP_HOST']=="www.student48.ru"))	echo('class="active"'); ?>>
                        <a href="news.php">�������</a>
                    </li>
                    <li <? if(($_SERVER['PHP_SELF']=="/materials.php") && ($_SERVER['HTTP_HOST']=="student48.ru") || ($_SERVER['HTTP_HOST']=="www.student48.ru"))	echo('class="active"'); ?>>
                        <a href="materials.php">���������</a>
                    </li>
                    <li <? if(($_SERVER['PHP_SELF']=="/questbook.php") && ($_SERVER['HTTP_HOST']=="student48.ru") || ($_SERVER['HTTP_HOST']=="www.student48.ru"))	echo('class="active"'); ?>>
                        <a href="questbook.php">��������</a>
                    </li>
                    <li <? if(($_SERVER['HTTP_HOST']=="files.student48.ru") || ($_SERVER['HTTP_HOST']=="www.files.student48.ru"))	echo('class="active"'); ?>>
                        <a href="http://files.student48.ru">��������</a>
                    </li>
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">��� <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="upload.php">��������</a></li>
                        <li><a href="shpora.php">�����</a></li>
                        <li><a href="rating.php">�������</a></li>
                        <li><a href="contacts.php">��������</a></li>
                        <li><a href="map.php">�����</a></li>
                        <li><a href="links.php">������</a></li>
                    </ul>
                </ul>
                <form class="navbar-search pull-right" action="">
                    <input type="text" class="search-query span2" placeholder="����� ����������">
                </form>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>