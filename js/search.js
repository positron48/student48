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

    function showQuickSearchResults(){
        $.post( "/ajax/sphinxsearch.php", { q: query})
            .done(function( data ) {
                block = false;
                if(data!="") {
                    $('#searchResult').remove();
                    $('#searchInput').parents('form').append(data);
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