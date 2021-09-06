$('#pagar').on('click', function(e){
    e.preventDefault();

    $.ajax({
        url: '/verifica-log-usuario',
        dataType: 'JSON',
        type: 'POST',
        success:function(ret){
            if(ret.log == false){
                window.location.href = '/login';
            }else{
                $('#selectPay').modal('show');
            }
        }
    })
})

$('#btnSelPgm').on('click', function(e){
    e.preventDefault();

    tpPgm = $("input[name='tpPgm']:checked").val();

    if(tpPgm != 'bol' && tpPgm != 'card'){
        $('#message').html('<br><div class="alert alert-danger" role="alert">Tipo de pagamento inválido!</div>');
    }else{
        if(tpPgm == 'card'){
            window.location.href = '/pagamento';
        }else if(tpPgm == 'bol'){
            window.location.href = '/gerar-boleto';
        }else{
            $('#message').html('<br><div class="alert alert-danger" role="alert">Tipo de pagamento inválido!</div>');
        }
    }
})