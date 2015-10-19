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
    });
    
    function refreshSelect(){
        var selectedSemestr = $('#semestr').val();
        if (selectedSemestr == 'none') {
            var str = "<option value='none'>Все предметы</option>";
            predmets.forEach(function(item,i,arr){
                if ($('#selectPredmet').attr('predmet')!='' && $('#selectPredmet').attr('predmet')==item[0]) {
                    str += "<option value='"+item[0]+"' selected>"+item[1]+"</option>";
                }else{
                    str += "<option value='"+item[0]+"'>"+item[1]+"</option>";
                }
            });
            $('#selectPredmet').html(str);
        }else{
            var str = "<option value='none'>Все предметы</option>";
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
});
