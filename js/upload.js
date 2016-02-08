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



    $('#selectPredmet').change(function(){
        //alert($('#selectPredmet option:selected').value);
        if($(this).val() == 'another'){
            $('#another_predmet').show();
        }else{
            $('#another_predmet').hide();
        }
    });

    $('#addMaterial').submit(function(){
        if(validateForm()) {
            $.ajax({
                url: '/ajax/addfile.php', //Адрес подгружаемой страницы
                type: "POST", //Тип запроса
                dataType: "html", //Тип данных
                data: $("#addMaterial").serialize(),
                success: function (response) { //Если все нормально
                    if (response == 'true')
                        document.location.href = '/upload/?success=Y&filename=' + $('input[name$=title]').val();
                    else
                        alert("При добавлении материала возникла ошибка, попробуйте добавить файл позднее, либо напишите администратору сайта/в гостевую.");
                },
                error: function (response) { //Если ошибка
                    alert("При добавлении материала возникла ошибка, попробуйте добавить файл позднее, либо напишите администратору сайта/в гостевую.");
                }
            });
        }
        return false;
    });

    //скрываем thank you block чтобы глаза не мозолил
    setTimeout("$('#succes_info').fadeOut(1000)",9000);

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

});
