$(function(){
    $('#alt_dados_pessoais').on('submit', function(e){
        e.preventDefault();

        nome      = $('input[name=nome]').val();
        senha_atu = $('input[name=senha_atu]').val();
        senha_nov = $('input[name=senha_nov]').val();
        senha_rep = $('input[name=senha_rep]').val();

        var formData = new FormData();
        formData.append('nome', $('input[name=nome]').val());
        formData.append('senha_atu', $('input[name=senha_atu]').val());
        formData.append('senha_nov', $('input[name=senha_nov]').val());
        formData.append('senha_rep', $('input[name=senha_rep]').val());
        formData.append('photo', $('input[name=photo]').prop('files')[0]);

        if(nome == ''){
            $('input[name=nome]').addClass('is-invalid');
            toastr.error('Campo "Nome" em branco!');
            return;
        }

        console.log('Senha atu: '+senha_atu)
        console.log('Senha nov: '+senha_nov)
        console.log('Senha rep: '+senha_rep)

        // if(senha_atu && senha_nov == ''){ 
        // //    senha_nov != '' && senha_atu == '' || senha_rep == '' ||
        // //    senha_rep != '' && senha_atu == '' || senha_nov == '') {
        //     $('input[name=senha_atu]').addClass('is-invalid');
        //     $('input[name=senha_nov]').addClass('is-invalid');
        //     $('input[name=senha_rep]').addClass('is-invalid');
        //     toastr.error('Existem campos "Senha atual", "Nova senha" ou "Repita nova senha" com um deles preenchido e outro em branco!');
        //     return;
        // }

        if(senha_nov != senha_rep){
            $('input[name=senha_nov]').addClass('is-invalid');
            $('input[name=senha_rep]').addClass('is-invalid');
            toastr.error('Campos "Nova senha" e "Repita nova senha" não batem');
            return;
        }

        $('input').removeClass('is-invalid');

        $.ajax({
            url: '/painel/alterar-dados-pessoais/update',
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            data:formData,
            dataType:'JSON',
            success:function(dados){
                if(dados == 0){
                    toastr.success('Dados atualizados com sucesso!');
                    setTimeout(function(){ window.location.reload() }, 1500);
                    return;        
                }else{
                    toastr.error(dados.error);
                    return;
                }
            }
        });
    })
})