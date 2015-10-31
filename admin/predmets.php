<? require($_SERVER['DOCUMENT_ROOT']."/include/head_before.php"); ?>

<?
if(!$isAdmin){
    header('Location: /admin/');
}
$predmets = $dbWorker->query("SELECT P.* FROM predmets P ORDER BY semestr ASC, title_predmet ASC");
?>
    <title>ЛГТУ | Предметы</title>
<? require($_SERVER['DOCUMENT_ROOT']."/include/head_after.php"); ?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/header.php"); ?>
    <h1>Предметы</h1>
    <br/>
    <div id="predmet">
        <form id="predmetForm" class="form-inline" method="post" action="/ajax/editpredmet.php">
            <table class="table table-striped table-bordered table-condensed">
                <tr><td><b>ID предмета: </b></td><td><input style="width:100%;" class="form-control" type="text" name="predmet_id"></td></tr>
                <tr><td><b>Семестр: </b></td><td><input style="width:100%;" class="form-control" type="text" name="semestr"></td></tr>
                <tr><td><b>Название предмета: </b></td><td><input style="width:100%;" class="form-control" type="text" name="title"></td></tr>
                <tr><td><b>Название на латинице: </b></td><td><input style="width:100%;" class="form-control" type="text" name="english_title"></td></tr>
            </table>
            <input type="submit" class="btn btn-success" value="Сохранить">
        </form>
    </div>
<?if($predmet = $predmets->fetch()){?>
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Id</th>
            <th>Семестр</th>
            <th>Название</th>
            <th>Название на латинице</th>
            <th><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></th>
            <th><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></th>
        </tr>
        </thead>
        <tbody>
        <?
        do{;?>
            <tr id="predmet_<?=$predmet['id']?>">
                <td class="predmet_id"><?=$predmet['id']?></td>
                <td class="semestr"><?=$predmet['semestr']?></td>
                <td class="title"><?=$predmet['title_predmet']?></td>
                <td class="english_title"><?=$predmet['title_predmet_english']?></td>
                <td class="edit">
                        <span
                            predmet_id="<?=$predmet['id']?>"
                            semestr="<?=$predmet['semestr']?>"
                            predmet_title="<?=$predmet['title_predmet']?>"
                            english_title="<?=$predmet['title_predmet_english']?>"
                            class="pmf-edit glyphicon glyphicon-pencil"
                            aria-hidden="true">
                        </span>
                </td>
                <td>
                    <span predmet_id="<?=$predmet['id']?>" class="pmf-remove glyphicon glyphicon-remove" aria-hidden="true"></span>
                </td>
            </tr>
        <?}while($predmet = $predmets->fetch());?>
        </tbody>
    </table>
<?}?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/footer.php"); ?>