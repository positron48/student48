<? require($_SERVER['DOCUMENT_ROOT']."/include/head_before.php"); ?>
<?
if(!$isAdmin){
    header('Location: /');
}
$pmFiles = $dbWorker->query("SELECT P.*, U.file_name_orig, Pr.title_predmet FROM pm_files P
  INNER JOIN uploads U ON P.pmfilename = U.link
  LEFT JOIN predmets Pr ON Pr.id = P.pmfilepredmetid
  ORDER BY pmfiledateadd ASC");
?>
<title>ЛГТУ | Модерация</title>
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
        </tr>
        </thead>
        <tbody>
            <?
            do{//print_r($file);?>
                <tr>
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
                    <td><?=$file['pmfiledateadd']?></td>
                </tr>
            <?}while($file = $pmFiles->fetch());?>
        </tbody>
    </table>
<?}else{?>
    <h3>Отсутствуют файлы на модерации.</h3>
<?}?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/footer.php"); ?>