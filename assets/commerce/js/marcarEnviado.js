$("#enviar").on("click", function(){
    id = $(this).attr("data");

    cd_ras = $('input[name=cd_rastreio]').val();

    if(cd_ras == ''){
        $('#message').html('<div class="alert alert-danger" role="alert">Campo do código de rastreio em branco, informe o código de rastreio dos Correios!</div>');
        return;
    }

    $('#message').html('');

    $.ajax({
        url: '/admin/painel/marcar-enviado',
        type: 'POST',
        dataType: 'JSON',
        data:{id:id, cd_ras:cd_ras},
        beforeSend: function(){
            $('#loading').html('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"></div><span class="visually-hidden"> &nbsp;&nbsp; Aguarde...</span></div>');
        },
        success:function(r){
            if(r.ret == true){
                $("#enviado").html("Enviado")
                $("#loading").html("")
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
                                window.location.reload();
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
        beforeSend: function(){
            $('#loading').html('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"></div><span class="visually-hidden"> &nbsp;&nbsp; Aguarde...</span></div>');
        },
        success:function(r){
            if(r.ret == true){
                $("#enviado").html("Não enviado")
                $("#loading").html("")
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
                                window.location.reload();
                            }
                        },
                        
                    }
                });
            }
        }
    })
})