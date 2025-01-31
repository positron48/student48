<? require($_SERVER['DOCUMENT_ROOT']."/include/head_before.php"); ?>

<title>ЛГТУ | Обменник</title>

<? require($_SERVER['DOCUMENT_ROOT']."/include/head_after.php"); ?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/header.php"); ?>

<!--input id="fileupload" type="file" name="files[]" data-url="upload.php" multiple-->
<h1>Файлообменник</h1>
<h3>Правила использования:</h3>
<ul>
    <li>можно загружать несколько файлов одновременно</li>
    <li>максимальный размер загружаемого файла: 256 Мб</li>
    <li>можно загружать файлы любого типа</li>
    <li>запрезается использовать данный ресурс в целях, противоречащих законодательству Российской Федерации</li>
    <li>срок хранения файлов временно не ограничен</li>
    <li>администрация сайта оставляет за собой право на удаление загруженных файлов и изменение условий использования файлообменника</li>
</ul>
<label class="uploadbutton">
    <div class="btn btn-info" >Выбрать</div>
    <div class='form-control'>Выберите файл</div>
    <input id="fileupload" type="file" name="files[]" data-url="upload.php" multiple
           onchange="this.previousSibling.previousSibling.innerHTML = this.value"/>
</label>

<div class="progress">
    <div class="progress-bar progress-bar-info progress-bar-striped"
         role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0">
        <span class="sr-only">40% Complete (success)</span>
    </div>
</div>
<table id="uploaded_files" class="table table-striped table-bordered table-condensed"></table>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="js/vendor/jquery.ui.widget.js"></script>
<script src="js/jquery.iframe-transport.js"></script>
<script src="js/jquery.fileupload.js"></script>
<script>
    $(function () {
        $('#fileupload').fileupload({
            dataType: 'json',
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('#uploaded_files').append('<tr><td><a href="'+file.name+'" target="_blank">'+file.name_orig+'</a></td>'
                        +'<td>'+Math.ceil(file.size/1024)+' Кб</a></td>'
                        +'<td><input type="text" class="form-control" value="http://student48.ru/files/'+file.name+'"></td>'
                        +'</tr>');
                });
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('.progress-bar').css(
                    'width',
                    progress + '%'
                );
            },
            error: function(data){
                $('<p/>').text(data.responseText).appendTo('#uploaded_files');
            }
        });
    });
</script>
<?if($isAdmin){?>
    <h2>Файлы в обменнике:</h2>
    <?
    $file = $dbWorker->prepare("SELECT * FROM uploads");
    $files = array();
    if($file->execute()){
        while($fileItem = $file->fetch()){
            $files[] = $fileItem;
        }
    }?>
    <table class="table table-striped table-bordered table-condensed">
        <tr>
            <td><b>Название </b></td>
            <td><b>Добавлено </b></td>
            <td><b>Последнее скачивание: </b></td>
            <td><b>Размер: </b></td>
            <td><b>Cкачиваний: </b></td>
        </tr>
        <?foreach ($files as $file) {?>
            <tr>
                <td style="width: 400px;"><a href="script/downloadnow.php?id=<?=$file['id']?>"><?=$file['file_name_orig']?></a></td>
                <td> <?=date('d.m.Y г. h:i ',strtotime($file['date_add']));?></td></>
                <td> <?=date('d.m.Y г. h:i ',strtotime($file['date_last_update']));?></td></>
                <td> <?=(int)($file['file_size']/1024)?> Kb</td></>
                <td> <?=$file['downloads']?></td>
            </tr>

        <?}?>
    </table>
<?}?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/footer.php"); ?>