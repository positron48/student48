<? require($_SERVER['DOCUMENT_ROOT']."/include/head_before.php"); ?>
<?


?>
<title>ЛГТУ | Авторизация</title>
<? require($_SERVER['DOCUMENT_ROOT']."/include/head_after.php"); ?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/header.php"); ?>
<? if(!$isAdmin){?>
    <h1 class="col-sm-offset-1">Авторизация</h1>

    <form class="form-horizontal" method="post">
        <br>
        <div class="form-group">
            <label for="login" class="col-sm-1 control-label">Логин</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="login" name="login">
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="col-sm-1 control-label">Пароль</label>
            <div class="col-sm-3">
                <input type="password" class="form-control" id="password" name="password">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-1 col-sm-10">
                <button type="submit" class="btn btn-default">Вход</button>
            </div>
        </div>
    </form>
<?}else{?>
    <h1>Административная панель</h1>
    <br/>
    <p><a href="/admin/moderation/">Модерация файлов</a></p>
    <p><a href="/admin/news/">Новости</a></p>
    <p><a href="/admin/predmets/">Предметы</a></p>

    <form class="form-horizontal" method="post">
        <br>
        <input type="hidden" name="logout">
        <div class="form-group">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-default">Выход</button>
            </div>
        </div>
    </form>
<?}?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/footer.php"); ?>