$(function(){
    $('#alt_dados_pessoais').on('submit', function(e){
        e.preventDefault();

        nome = $('input[name=nome]').val();
        senha_atu = $('input[name=senha_atu]').val();
        senha_nov = $('input[name=senha_nov]').val();
        senha_rep = $('input[name=senha_atu]').val();
        foto      = $('input[name=foto]').val();

        if(nome == ''){
            $('input[name=nome]').addClass('is-invalid');
            toastr.error('Campo "Nome" em branco!');
            return;
        }

        if((senha_atu != '' && senha_nov == '') || 
           (senha_atu != '' && senha_rep == '') || 
           (senha_atu != '' && senha_nov != '' && senha_atu == '') || 
           ((senha_nov != '' || senha_rep != '') && senha_atu == '')){
            $('input[name=senha_atu]').addClass('is-invalid');
            $('input[name=senha_nov]').addClass('is-invalid');
            $('input[name=senha_rep]').addClass('is-invalid');
            toastr.error('Existem campos "Senha atual", "Nova senha" ou "Repita nova senha" com um deles preenchido e outro em branco!');
            return;
        }

        $('input').removeClass('is-invalid');

        $('input[name=nome]').removeClass('is-invalid');

        $.ajax({
            url: '/painel/alterar-dados-pessoais/update',
            type: 'POST',
            data:{
                nome:nome,
                senha_atu:senha_atu,
                senha_nov:senha_nov,
                senha_repsenha_rep,
                foto:foto
            },
            dataType:'JSON',
            success:function(dados){
                if(dados.error == 1){
                    toastr.error('Campo "Nome" em branco!');
                    return;        
                }


            }
        });
    })
})