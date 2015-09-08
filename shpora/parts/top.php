	<table cellpadding="0" cellspacing="0">
        <tr>
            <div id="top">
                <td width="51" class="bottom">у</td>
                <td class=<? if(($_SERVER['PHP_SELF']=="/index.php") && ($_SERVER['HTTP_HOST']=="student48.ru") || ($_SERVER['HTTP_HOST']=="www.student48.ru"))	echo('"aktiv_button">'); else echo('"top_button">'); ?>
                <a href="http://student48.ru/index.php" class="button">
                    <div class="button">
                        Главная
                    </div>
                </a>  
                </td>
                <td width="60" class="bottom">п</td>
                <td class=<? if($_SERVER['PHP_SELF']=="/news.php")	echo('"aktiv_button">'); else echo('"top_button">'); ?>
                <a href="http://student48.ru/news.php" class="button">
                	<div class="button">
                        Новости
                    </div>
                </a>
                </td>
                <td width="60" class="bottom">я</td>
                <td class=<? if($_SERVER['PHP_SELF']=="/materials.php")	echo('"aktiv_button">'); else echo('"top_button">'); ?>
                <a href="http://student48.ru/materials.php" class="button">
                	<div class="button">
                        Материалы
                    </div>
                </a>
                </td>
                <td width="60" class="bottom">ч</td>
                <td class=<? if($_SERVER['PHP_SELF']=="/questbook.php")	echo('"aktiv_button">'); else echo('"top_button">'); ?>
                <a href="http://student48.ru/questbook.php" class="button">
                	<div class="button">
                        Гостевая
                    </div>
                </a>
                </td>
                <td width="60" class="bottom">к</td>
                <td class=<? if(($_SERVER['HTTP_HOST']=="files.student48.ru") || ($_SERVER['HTTP_HOST']=="www.files.student48.ru"))	echo('"aktiv_button">'); else echo('"top_button">'); ?>
                <a href="http://files.student48.ru/" class="button">
                	<div class="button">
                        Обменник
                    </div>
                </a>
                </td>
                <td width="51" class="bottom">а</td>
            </div>
        </tr>
    </table>