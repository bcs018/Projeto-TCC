$('#login_cliente').on('submit', function(e){
    e.preventDefault();

    login = $('input[name=login]').val();
    senha = $('input[name=senha]').val();

    $.ajax({
        url: '/cliente/logar',
        dataType: 'JSON',
        type: 'POST',
        data:{login:login, senha:senha},
        success:function(ret){
            if(ret.login == true){
                window.history.back();
            }else{
                $('#message').html('<div class="alert alert-danger" role="alert">Login, Email e/ou Senha incorretos!</div>');
            }
        }

    })
})