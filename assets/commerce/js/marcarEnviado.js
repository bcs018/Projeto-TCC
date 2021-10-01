$("#enviar").on("click", function(){
    id = $(this).attr("data");

    $.ajax({
        url: '/admin/painel/marcar-enviado',
        type: 'POST',
        dataType: 'JSON',
        data:{id:id},
        success:function(r){
            if(r.ret == true){
                $("#enviado").html("Enviado")
                $.confirm({
                    title: 'Marcado como ENVIADO',
                    content: '',
                    type: 'green',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'OK',
                            btnClass: 'btn-green',
                            action: function(){
                            }
                        },
                        
                    }
                });
            }
        }
    })
})

$("#naoenviar").on("click", function(){
    id = $(this).attr("data");

    $.ajax({
        url: '/admin/painel/marcar-nao-enviado',
        type: 'POST',
        dataType: 'JSON',
        data:{id:id},
        success:function(r){
            if(r.ret == true){
                $("#enviado").html("Não enviado")
                $.confirm({
                    title: 'Marcado como NÃO ENVIADO',
                    content: '',
                    type: 'green',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'OK',
                            btnClass: 'btn-green',
                            action: function(){
                            }
                        },
                        
                    }
                });
            }
        }
    })
})