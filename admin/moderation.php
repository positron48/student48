<? require($_SERVER['DOCUMENT_ROOT']."/include/head_before.php"); ?>

<?
if(!$isAdmin){
    header('Location: /admin/');
}
$pmFiles = $dbWorker->query("SELECT P.*, U.file_name_orig, Pr.title_predmet, Pr.title_predmet_english FROM pm_files P
  INNER JOIN uploads U ON P.pmfilename = U.link
  LEFT JOIN predmets Pr ON Pr.id = P.pmfilepredmetid
  ORDER BY pmfiledateadd ASC");

//все предметы по семестрам
$dbPredmets=$dbWorker->query("SELECT semestr, title_predmet_english, title_predmet FROM predmets ORDER BY title_predmet ASC");
$arSemestrPredmets=array();
$arPredmets=array();
while($predmetRes = $dbPredmets->fetch()){
    $arSemestrPredmets[(int)$predmetRes['semestr']][]= array($predmetRes['title_predmet_english'],$predmetRes['title_predmet']);
    $arPredmets[$predmetRes['title_predmet_english']] = array($predmetRes['title_predmet_english'],$predmetRes['title_predmet']);
}
?>
<title>ЛГТУ | Модерация</title>

<script>
    predmetSemestr = <? echo json_encode($arSemestrPredmets);?>;
    predmets = <? echo json_encode(array_values($arPredmets));?>;
</script>
<script src="/files/js/vendor/jquery.ui.widget.js"></script>
<script src="/files/js/jquery.iframe-transport.js"></script>
<script src="/files/js/jquery.fileupload.js"></script>
<style>
    .progress {
        width: 50%;
        margin-left: 15px;
        height: 34px;
        margin-bottom: 0;
    }
</style>

<link rel="stylesheet" href="/css/moderation.css">

<? require($_SERVER['DOCUMENT_ROOT']."/include/head_after.php"); ?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/header.php"); ?>

<h1>Модерация</h1>
<br/>
<div id="editMaterial">
    <form id="editMaterialForm" class="form-inline" method="post" action="/ajax/editfile.php">
        <table class="table table-striped table-bordered table-condensed">
            <tr><td><b>Семестр: </b></td><td>
                <select name="semestr" id="semestr" class="form-control">');
                    <option value="none" selected>Все семестры</option>
                    <?for($i=1;$i<=10;$i++){?>
                        <option value="<?=$i?>"><?=$i?></option>
                    <?}?>
                </select></td>
            </tr>
            <tr><td><b>Предмет: </b></td><td>
                <select id="selectPredmet" name="predmet" class="form-control">
                    <option value="none" selected>Все предметы</option>
                </select></td>
            </tr>
            <tr id="another_predmet"><td><b>Название предмета: </b></td><td><input style="width:100%;" class="form-control" type="text" name="new_predmet"></td></tr>
            <tr><td><b>Название материала: </b></td><td><input style="width:100%;" class="form-control" type="text" name="title"></td></tr>
            <tr><td><b>Ключевые слова: </b></td><td><input style="width:100%;" class="form-control" type="text" name="keywords"></td></tr>
            <tr><td><b>Файл: </b></td><td>
                <label class="addbutton">
                    <div class="btn btn-info" >Выбрать</div>
                    <div class='form-control'>Выберите файл</div>
                    <input id="fileupload" type="file" name="files[]" data-url="/files/upload.php"
                           onchange="this.previousSibling.previousSibling.innerHTML = this.value"/>
                    <div class="progress upload-progress">
                        <div class="progress-bar progress-bar-info progress-bar-striped"
                             role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0">
                            <span class="sr-only">40% Complete (success)</span>
                        </div>
                    </div>
                </label></td>
            </tr>
            <input type="hidden" id="file" name="link">
            <input type="hidden" name="fileid">
        </table>
        <input type="submit" class="btn btn-success" value="Сохранить">
    </form>
</div>
<?if($file = $pmFiles->fetch()){?>
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Название</th>
            <th>Семестр</th>
            <th>Предмет</th>
            <th>Ключевые слова</th>
            <th>Имя файла</th>
            <th>Дата добавления</th>
            <th><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></th>
            <th><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></th>
            <th><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></th>
        </tr>
        </thead>
        <tbody>
            <?
            do{;?>
                <tr id="pmf_<?=$file['pmfileid']?>">
                    <td class="pmfiletitle"><?=$file['pmfiletitle']?></td>
                    <td class="pmfilepredmetsemestr"><?=$file['pmfilepredmetsemestr']?></td>
                    <td class="pmfilepredmetname"><?=$file['pmfilepredmetname']?
                        $file['pmfilepredmetname']:
                        '<a href="#">'.$file['title_predmet'].'</a>'?>
                    </td>
                    <td class="pmfilemetakey"><?=$file['pmfilemetakey']?></td>
                    <td class="pmfilename">
                        <a href='/files/script/downloadnow.php?id=<?=$file['pmfilename']?>'>
                            <?=$file['file_name_orig']?>
                        </a>
                    </td>
                    <td><?=date('d.m.Y', strtotime($file['pmfiledateadd']));?> г.</td>
                    <td>
                        <span pmf_id="<?=$file['pmfileid']?>" class="pmf-ok glyphicon glyphicon-ok" aria-hidden="true"></span>
                    </td>
                    <td class="edit">
                        <span
                            pmf_id="<?=$file['pmfileid']?>"
                            semestr="<?=$file['pmfilepredmetsemestr']?>"
                            predmet_id="<?=$file['pmfilepredmetid']?>"
                            file_title="<?=$file['pmfiletitle']?>"
                            meta_key="<?=$file['pmfilemetakey']?>"
                            file_name="<?=$file['pmfilename']?>"
                            predmet_name="<?=isset($file['pmfilepredmetname'])?$file['pmfilepredmetname']:''?>"
                            title_predmet_english="<?=!empty($file['title_predmet_english'])?$file['title_predmet_english']:'another'?>"
                            class="pmf-edit glyphicon glyphicon-pencil"
                            aria-hidden="true">
                        </span>
                    </td>
                    <td>
                        <span pmf_id="<?=$file['pmfileid']?>" class="pmf-remove glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </td>
                </tr>
            <?}while($file = $pmFiles->fetch());?>
        </tbody>
    </table>
<?}else{?>
    <h3>Отсутствуют файлы на модерации.</h3>
<?}?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/footer.php"); ?>