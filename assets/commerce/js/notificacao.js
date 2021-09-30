$(".notify").on("click", function(){

    id = $(this).attr("id");
    id = id.split("-");
    link = $(this).attr('data');

    $.ajax({
        url: '/admin/painel/ler-notificacao',
        type: 'POST',
        dataType: 'JSON',
        data: {id:id[1]},
        success:function(r){
            if(r.ret == true){
                if(link == ''){
                    window.location.reload();
                }else{
                    window.location.href = link;
                }
            }
        }
    })
});

$(".dropdown-footer").on("click", function(){
    $.ajax({
        url: '/admin/painel/ler-todas-notificacao',
        type: 'POST',
        dataType: 'JSON',
        success:function(r){
            window.location.reload();
        }
    })
})