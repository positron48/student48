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
                        <a href="http://student48.ru/index.php">�������</a>
                    </li>
                    <li <? if(($_SERVER['PHP_SELF']=="/news.php") && ($_SERVER['HTTP_HOST']=="student48.ru") || ($_SERVER['HTTP_HOST']=="www.student48.ru"))	echo('class="active"'); ?>>
                        <a href="http://student48.ru/news.php">�������</a>
                    </li>
                    <li <? if(($_SERVER['PHP_SELF']=="/materials.php") && ($_SERVER['HTTP_HOST']=="student48.ru") || ($_SERVER['HTTP_HOST']=="www.student48.ru"))	echo('class="active"'); ?>>
                        <a href="http://student48.ru/materials.php">���������</a>
                    </li>
                    <li <? if(($_SERVER['PHP_SELF']=="/questbook.php") && ($_SERVER['HTTP_HOST']=="student48.ru") || ($_SERVER['HTTP_HOST']=="www.student48.ru"))	echo('class="active"'); ?>>
                        <a href="http://student48.ru/questbook.php">��������</a>
                    </li>
                    <li <? if(($_SERVER['HTTP_HOST']=="files.student48.ru") || ($_SERVER['HTTP_HOST']=="www.files.student48.ru"))	echo('class="active"'); ?>>
                        <a href="http://files.student48.ru">��������</a>
                    </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                          ���
                          <i class="caret"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="http://student48.ru/upload.php">��������</a></li>
                            <li><a href="http://student48.ru/shpora">�����</a></li>
                            <li><a href="http://student48.ru/rating.php">�������</a></li>
                            <li><a href="http://student48.ru/contacts.php">��������</a></li>
                            <li><a href="http://student48.ru/map.php">�����</a></li>
                            <li><a href="http://student48.ru/links.php">������</a></li>
                            <li><a href="http://vk.com/student48ru">���������</a></li>
                        </ul>
                      </li>
                </ul>
                <form class="navbar-search pull-right" action="http://student48.ru/search.php" method="GET">
                    <button type="submit" class="btn btn-inverse pull-right" style="margin-top: 0px;">�����</button><input type="text" class="search-query span2" placeholder="����� ����������" name="search_text"></input>
                    
                </form>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>