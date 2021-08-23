$('#login_cliente').on('submit', function(e){
    e.preventDefault();

    login   = $('input[name=login]').val();
    senha   = $('input[name=senha]').val();
    control = $('input[name=control]').val();

    $.ajax({
        url: '/cliente/logar',
        dataType: 'JSON',
        type: 'POST',
        data:{login:login, senha:senha, control:control},
        success:function(ret){
            if(ret.login == true && ret.control == false){
                window.history.back();
            }else if(ret.login == true && ret.control == true){
                window.location.href = '/cliente/painel';
            }else{
                $('#message').html('<div class="alert alert-danger" role="alert">Login, Email e/ou Senha incorretos!</div>');
            }
        }

    })
})