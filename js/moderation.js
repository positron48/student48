$(document).ready(function(){
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
    $('.pmf-edit').click(function(){

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
});
