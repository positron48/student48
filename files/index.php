<? require($_SERVER['DOCUMENT_ROOT']."/include/head_before.php"); ?>

<title>ЛГТУ | Обменник</title>

<? require($_SERVER['DOCUMENT_ROOT']."/include/head_after.php"); ?>
<? require($_SERVER['DOCUMENT_ROOT']."/include/header.php"); ?>

<input id="fileupload" type="file" name="files[]" data-url="server/php/" multiple>
<div id="progress">
    <div class="bar" style="width: 0%;"></div>
</div>

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
                    $('<p/>').text(file.name).appendTo(document.body);
                });
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .bar').css(
                    'width',
                    progress + '%'
                );
            },
            error: function(data){
                $('<p/>').text(data.responseText).appendTo(document.body);
            }
        });
    });
</script>

<? require($_SERVER['DOCUMENT_ROOT']."/include/footer.php"); ?>