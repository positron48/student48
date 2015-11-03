$(document).ready(function(){
    refreshSelect();

    $('#selectButton').click(function(){
        var newLocation = '/materials/';
        if ($('#selectPredmet').val() != 'none') {
            newLocation += $('#selectPredmet').val()+'/';
        }
        if ($('#semestr').val() != 'none') {
            newLocation += 'semestr' + $('#semestr').val()+'/';
        }
        window.location.href = newLocation;
    });

    $('#semestr').change(function(){
        refreshSelect();
        if($('#selectPredmet').val() == 'another'){
            $('#another_predmet').show();
        }else{
            $('#another_predmet').hide();
        }
    });

    function refreshSelect(){
        var selectedSemestr = $('#semestr').val();
        if (selectedSemestr == 'none') {
            var str = "<option value='none'>Все предметы</option><option value='another'>Другой предмет</option>";
            predmets.forEach(function(item,i,arr){
                if ($('#selectPredmet').attr('predmet')!='' && $('#selectPredmet').attr('predmet')==item[0]) {
                    str += "<option value='"+item[0]+"' selected>"+item[1]+"</option>";
                }else{
                    str += "<option value='"+item[0]+"'>"+item[1]+"</option>";
                }
            });
            $('#selectPredmet').html(str);
        }else{
            var str = "<option value='none'>Все предметы</option><option value='another'>Другой предмет</option>";
            for(var i in predmetSemestr){
                if (i==selectedSemestr) {
                    predmetSemestr[i].forEach(function(item,j,array){
                        if ($('#selectPredmet').attr('predmet')!='' && $('#selectPredmet').attr('predmet')==item[0]) {
                            str += "<option value='"+item[0]+"' selected>"+item[1]+"</option>";
                        }else{
                            str += "<option value='"+item[0]+"'>"+item[1]+"</option>";
                        }
                    });
                }
            }
            $('#selectPredmet').html(str);
        }
    }

    $(function () {
        $('#fileupload').fileupload({
            dataType: 'json',
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('#file').val(file.name);
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
                alert(data.responseText);
            }
        });
    });

    $('#selectPredmet').change(function(){
        //alert($('#selectPredmet option:selected').value);
        if($(this).val() == 'another'){
            $('#another_predmet').show();
        }else{
            $('#another_predmet').hide();
        }
    });

    $('#editMaterialForm').submit(function(){
        if(validateForm()) {
            $.ajax({
                url: '/ajax/editfile.php', //Адрес подгружаемой страницы
                type: "POST", //Тип запроса
                dataType: "html", //Тип данных
                data: $("#editMaterialForm").serialize(),
                success: function (response) { //Если все нормально
                    if (response == 'true') {
                        //скрываем форму
                        window.location.href = '/admin/moderation/';
                    }else {
                        alert("При изменении материала возникла ошибка, попробуйте добавить файл позднее, либо напишите администратору сайта/в гостевую.");
                    }
                },
                error: function (response) { //Если ошибка
                    alert("При добавлении материала возникла ошибка, попробуйте добавить файл позднее, либо напишите администратору сайта/в гостевую.");
                }
            });
        }
        //alert('111222333');
        return false;
    });

    function validateForm(){
        var error = '';
        if($('#semestr').val()=='none')
            error+="выберите семестр\n";
        if($('#selectPredmet').val()=='none')
            error+="выберите предмет\n";
        if($('#selectPredmet').val()=='another' && $('input[name$=new_predmet]').val()=='')
            error+="введите название нового предмета\n";
        if($('input[name$=title]').val()=='')
            error+="введите название материала\n";
        if($('#file').val()=='')
            error+="загрузите файл\n";
        if(error !='')
        {
            error = "Не заполнено одно или несколько полей формы:\n"+error;
            alert(error);
            return false;
        }

        return true;
    }
    $('.pmf-ok').click(function(){
        if(confirm('Вы действительно хотите добавить данный материал на сайт?')){
            var id=$(this).attr('pmf_id');
            $.post( "/ajax/moderation.php", { action: "pmf_ok", id: id })
                .done(function(data) {
                    if(data === 'true') {
                        $('#pmf_' + id).hide();
                    }else{
                        alert('При добавлении файла возникла ошибка');
                    }
                });
        }
    });
    $('.pmf-remove').click(function(){
        if(confirm('Вы действительно хотите удалить данный материал?')){
            var id=$(this).attr('pmf_id');
            $.post( "/ajax/moderation.php", { action: "pmf_remove", id: id })
                .done(function(data) {
                    if(data === 'true') {
                        $('#pmf_' + id).hide();
                    }else{
                        alert('При удалении файла возникла ошибка');
                    }
                });
        }
    });
    $('.pmf-edit').click(function(){
        $('#editMaterialForm').trigger( 'reset' );
        $('#editMaterial').show();
        $('#editMaterialForm input[name=title]').val($(this).attr('file_title'));
        $('#editMaterialForm input[name=keywords]').val($(this).attr('meta_key'));
        $('#editMaterialForm input[name=link]').val($(this).attr('file_name'));
        $('#editMaterialForm input[name=fileid]').val($(this).attr('pmf_id'));
        $('#editMaterialForm input[name=new_predmet]').val($(this).attr('predmet_name'));
        $('#semestr').val($(this).attr('semestr')).change();
        $('#selectPredmet').val($(this).attr('title_predmet_english')).change();
    });
});
