<? require($_SERVER['DOCUMENT_ROOT']."/include/head_before.php"); ?>

<?
if(!$isAdmin){
    header('Location: /admin/');
}
$dbNews=$dbWorker->prepare("SELECT * FROM news ORDER BY id DESC");
$dbNews->execute();
?>
<title>ЛГТУ | Админка - Новости</title>

<link rel="stylesheet" href="/css/moderation.css">

<? require($_SERVER['DOCUMENT_ROOT']."/include/head_after.php"); ?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/header.php"); ?>

    <title>ЛГТУ | Предметы</title>

    <link rel="stylesheet" href="/css/moderation.css">
<? require($_SERVER['DOCUMENT_ROOT']."/include/head_after.php"); ?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/header.php"); ?>
    <h1>Новости <span class="news-add glyphicon glyphicon-plus" aria-hidden="true"></span></h1>
    <br/>
    <div id="news">
        <form id="newsForm" class="form-inline" action="/ajax/editpredmet.php">
            <table class="table table-striped table-bordered table-condensed">
                <tr><td><b>ID новости: </b></td><td><input style="width:100%;" class="form-control" type="text" name="news_id" readonly></td></tr>
                <tr><td><b>Заголовок: </b></td><td><input style="width:100%;" class="form-control" type="text" name="title_news"></td></tr>
                <tr><td><b>Дата создания: </b></td><td><input style="width:100%;" class="form-control" type="text" name="datecreate"></td></tr>
                <tr><td><b>Дата обновления: </b></td><td><input style="width:100%;" class="form-control" type="text" name="dateupdate"></td></tr>
                <tr><td><b>Дата последнего просмотра: </b></td><td><input style="width:100%;" class="form-control" type="text" name="dateview"></td></tr>
                <tr><td><b>Просмотров: </b></td><td><input style="width:100%;" class="form-control" type="text" name="views"></td></tr>
                <tr><td><b>Ключевые слова: </b></td><td><input style="width:100%;" class="form-control" type="text" name="metakey"></td></tr>
                <tr><td><b>Анонс: </b></td><td><textarea style="width:886px; height: 56pt;" class="form-control" type="text" name="introtext"></textarea></td></tr>
                <tr><td><b>Детальный текст: </b></td><td><textarea style="width:886px;height: 150pt;" class="form-control" type="text" name="fullcontent"></textarea></td></tr>
            </table>
            <input type="submit" class="btn btn-success" value="Сохранить">
        </form>
    </div>
<?if($news = $dbNews->fetch()){?>
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Id</th>
            <th>Заголовок</th>
            <th>Анонс</th>
            <th>Дата</th>
            <th>Просмотры</th>
            <th><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></th>
            <th><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></th>
        </tr>
        </thead>
        <tbody>
        <?
        do{;?>
            <tr id="news_<?=$news['id']?>">
                <td class="news_id"><?=$news['id']?></td>
                <td class="title"><?=$news['title_news']?></td>
                <td class="introtext"><?=$news['introtext']?></td>
                <td class="dateCreate"><?=date('d.m.Y',strtotime($news['datecreate']))?></td>
                <td class="views"><?=$news['views']?></td>
                <td class="edit">
                        <span
                            news_id="<?=$news['id']?>"
                            title_news="<?=$news['title_news']?>"
                            introtext="<?=htmlspecialchars($news['introtext'])?>"
                            fullcontent="<?=htmlspecialchars($news['fullcontent'])?>"
                            metakey="<?=$news['metakey']?>"
                            datecreate="<?=$news['datecreate']?>"
                            dateupdate="<?=$news['dateupdate']?>"
                            dateview="<?=$news['dateview']?>"
                            views="<?=$news['views']?>"
                            class="news-edit glyphicon glyphicon-pencil"
                            aria-hidden="true">
                        </span>
                </td>
                <td>
                    <span news_id="<?=$news['id']?>" class="news-remove glyphicon glyphicon-remove" aria-hidden="true"></span>
                </td>
            </tr>
        <?}while($news = $dbNews->fetch());?>
        </tbody>
    </table>
<?}?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/footer.php"); ?>