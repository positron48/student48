$(document).ready(function(){

    $('#predmetForm').submit(function(){
        if(validateForm()) {
            $.ajax({
                url: '/ajax/editpredmet.php', //Адрес подгружаемой страницы
                type: "POST", //Тип запроса
                dataType: "html", //Тип данных
                data: $("#predmetForm").serialize(),
                success: function (response) { //Если все нормально
                    if (response == 'true') {
                        //скрываем форму
                        window.location.href = '/admin/predmets/';
                    }else {
                        alert("При изменении предмета возникла ошибка");
                    }
                },
                error: function (response) { //Если ошибка
                    alert("При изменении предмета возникла ошибка.");
                }
            });
        }
        return false;
    });

    function validateForm(){
        var error = '';
        if($('#predmetForm input[name=semestr]').val()=='')
            error+="укажите семестр\n";
        if($('#predmetForm input[name=title]').val()=='')
            error+="укажите название предмета\n";
        if($('#predmetForm input[name=english_title]').val()=='')
            error+="укажите латинское название предмета\n";
        if(error !=''){
            error = "Не заполнено одно или несколько полей формы:\n"+error;
            alert(error);
            return false;
        }
        return true;
    }

    $('.predmet-remove').click(function(){
        if(confirm('Вы действительно хотите удалить данный предмет?')){
            var id=$(this).attr('predmet_id');
            $.post( "/ajax/editpredmet.php", {  predmet_id: id })
                .done(function(data) {
                    if(data === 'true') {
                        $('#predmet_' + id).hide();
                    }else{
                        alert('При удалении файла возникла ошибка' + data);
                    }
                });
        }
    });
    $('.predmet-edit').click(function(){
        $('#predmetForm').trigger( 'reset' );
        $('#predmet').show();
        $('#predmetForm input[name=predmet_id]').val($(this).attr('predmet_id'));
        $('#predmetForm input[name=semestr]').val($(this).attr('semestr'));
        $('#predmetForm input[name=title]').val($(this).attr('predmet_title'));
        $('#predmetForm input[name=english_title]').val($(this).attr('english_title'));
    });
    $('.predmet-add').click(function(){
        $('#predmetForm').trigger( 'reset' );
        $('#predmet').show();
    });
});
