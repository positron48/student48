$(document).ready(function(){
    var options = { 
        beforeSubmit:  validate, 
        success:       showResponse,  
        url:           '/ajax/questbook.php',
        type:          'POST',
        dataType:      'json'
    }; 
    $('#addMessageForm').ajaxForm(options);
    
    function validate(formData, jqForm, options) { 
        var errors='';
        for (var i=0; i < formData.length; i++) {
            if (formData[i].name=='imNotRobot') {
                if (formData[i].value=='N') {
                    alert('Роботам нельзя писать сообщения!'); 
                    return false; 
                }
            }else if (!formData[i].value) { 
                alert('Заполните поля!'); 
                return false; 
            } 
        }
        return true;
    }
 
    function showResponse(responseText, statusText, xhr, $form)  {
        if (responseText==true) {
            location.reload();
        }else{
            alert('При добавлении записи произошла ошибка, попробуйте отправить сообщение еще раз.');
        }
    } 
});