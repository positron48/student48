$(document).ready(function(){
    query = "";
    block = false;
    var input = document.getElementById("searchInput");
    input.oninput = function() {
        var tmp = $('#searchInput').val();
        if(tmp.length>1 && tmp!=query && !block){
            query = tmp;
            block = true;
            showQuickSearchResults();
        }else if(tmp == ""){
            $('#searchResult').remove();
        }
    };

    $('#searchInput').focusout(function(){
        $('#searchResult').hide();
    });

    $('#searchInput').focus(function(){
        $('#searchResult').show();
    });

    function showQuickSearchResults(){
        $.post( "/ajax/sphinxsearch.php", { q: query})
            .done(function( data ) {
                block = false;
                if(data!="") {
                    $('#searchResult').remove();
                    $('#searchInput').parents('form').after(data);
                }
                var tmp = $('#search_form input').val();
                if(tmp.length>1 && tmp!=query && !block){
                    query = tmp;
                    block = true;
                    showQuickSearchResults();
                }else if(tmp == ""){
                    $('#searchResult').remove();
                }
            });
    }
});