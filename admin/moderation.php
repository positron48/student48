<? require($_SERVER['DOCUMENT_ROOT']."/include/head_before.php"); ?>

<?
if(!$isAdmin){
    header('Location: /admin/');
}
$pmFiles = $dbWorker->query("SELECT P.*, U.file_name_orig, Pr.title_predmet FROM pm_files P
  INNER JOIN uploads U ON P.pmfilename = U.link
  LEFT JOIN predmets Pr ON Pr.id = P.pmfilepredmetid
  ORDER BY pmfiledateadd ASC");
?>

<title>ЛГТУ | Модерация</title>
<link rel="stylesheet" href="/css/moderation.css">
<script src="/js/moderation.js"></script>

<? require($_SERVER['DOCUMENT_ROOT']."/include/head_after.php"); ?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/header.php"); ?>

<h1>Модерация</h1>
<br/>
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
                    <td><?=$file['pmfiletitle']?></td>
                    <td><?=$file['pmfilepredmetsemestr']?></td>
                    <td><?=$file['pmfilepredmetname']?
                        $file['pmfilepredmetname']:
                        '<a href="#">'.$file['title_predmet'].'</a>'?>
                    </td>
                    <td><?=$file['pmfilemetakey']?></td>
                    <td>
                        <a href='/files/script/downloadnow.php?id=<?=$file['pmfilename']?>'>
                            <?=$file['file_name_orig']?>
                        </a>
                    </td>
                    <td><?=date('d.m.Y', strtotime($file['pmfiledateadd']));?> г.</td>
                    <td>
                        <span pmf_id="<?=$file['pmfileid']?>" class="pmf-ok glyphicon glyphicon-ok" aria-hidden="true"></span>
                    </td>
                    <td>
                        <span pmf_id="<?=$file['pmfileid']?>" class="pmf-edit glyphicon glyphicon-pencil" aria-hidden="true"></span>
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