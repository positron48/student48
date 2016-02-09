$(document).ready(function(){
    $('#news').hide();
    $('#newsForm').submit(function(){
        if(validateForm()) {
            $.ajax({
                url: '/ajax/editnews.php', //Адрес подгружаемой страницы
                type: "POST", //Тип запроса
                dataType: "html", //Тип данных
                data: $("#newsForm").serialize(),
                success: function (response) { //Если все нормально
                    if (response == 'true') {
                        //скрываем форму
                        window.location.href = '/admin/news/';
                    }else {
                        alert("При изменении предмета возникла ошибка"+response);
                    }
                },
                error: function (response) { //Если ошибка
                    alert("При изменении предмета возникла ошибка."+response);
                }
            });
        }
        return false;
    });

    function validateForm(){
        var error = '';
        if($('#newsForm input[name=title_news]').val()=='')
            error+="укажите pfujkjdjr\n";
        if($('#newsForm input[name=introtext]').val()=='')
            error+="укажите текст анонса\n";
        if($('#newsForm input[name=fullcontent]').val()=='')
            error+="укажите текст новости\n";
        if(error !=''){
            error = "Не заполнено одно или несколько полей формы:\n"+error;
            alert(error);
            return false;
        }
        return true;
    }

    $('.news-remove').click(function(){
        if(confirm('Вы действительно хотите удалить данную новость?')){
            var id=$(this).attr('news_id');
            $.post( "/ajax/editnews.php", {  news_id: id })
                .done(function(data) {
                    if(data === 'true') {
                        $('#news_' + id).hide();
                    }else{
                        alert('При удалении файла возникла ошибка' + data);
                    }
                });
        }
    });
    $('.news-edit').click(function(){
        $('#newsForm').trigger( 'reset' );
        $('#newsForm textarea[name=introtext]').html('');
        $('#newsForm textarea[name=fullcontent]').html('');
        $('#news').show();
        $('#newsForm input[name=news_id]').val($(this).attr('news_id'));
        $('#newsForm input[name=title_news]').val($(this).attr('title_news'));
        $('#newsForm textarea[name=introtext]').html($(this).attr('introtext'));
        $('#newsForm textarea[name=fullcontent]').html($(this).attr('fullcontent'));
        $('#newsForm input[name=metakey]').val($(this).attr('metakey'));
        $('#newsForm input[name=datecreate]').val($(this).attr('datecreate'));
        $('#newsForm input[name=dateupdate]').val($(this).attr('dateupdate'));
        $('#newsForm input[name=dateview]').val($(this).attr('dateview'));
        $('#newsForm input[name=views]').val($(this).attr('views'));
    });
    $('.news-add').click(function(){
        $('#newsForm').trigger( 'reset' );
        $('#newsForm textarea[name=introtext]').html('');
        $('#newsForm textarea[name=fullcontent]').html('');
        $('#news').show();
    });
});
