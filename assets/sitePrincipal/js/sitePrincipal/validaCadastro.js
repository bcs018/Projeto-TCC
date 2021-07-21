$(function(){
    $('#cadastro').on('submit', function(e){
        e.preventDefault();

        $.ajax({
            url: '/crie-sua-loja/inserir',
            type: 'POST',
            data: {
                nome_usu: $('#nome_usu').val(),
                celular: $('#celular').val(),
                rua_usu: $('#rua_usu').val(),
                cep_usu: $('#cep_usu').val(),
                sobrenome_usu: $('#sobrenome_usu').val(),
                cpf_usu: $('#cpf_usu').val(),
                bairro_usu: $('#bairro_usu').val(),
                estado_usu: $('#estado_usu').val(),
                email_usu: $('#email_usu').val(),
                data_nasc: $('#data_nasc').val(),
                num_usu: $('#num_usu').val(),
                subdominio: $('#subdominio').val(),
                nome_fan: $('#nome_fan').val(),
                cnpj: $('#cnpj').val(),
                senha: $('#senha').val(),
                rep_senha: $('#rep_senha').val(),
                cidade: $('#cidade_usu').val(),
                complemento:$('#complemento').val()
            },
            dataType: 'JSON',
            beforeSend: function(){
                $('#loading').html('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"></div><span class="visually-hidden"> &nbsp;&nbsp; Carregando...</span></div>');
            },
            success:function(dados){
                if(dados.message == 1){
                    $('#retorno').html('<div class="alert alert-success" role="alert">Cadastro efetuado com sucesso! Clique em "Próximo" para proseguir &nbsp <a href="/crie-sua-loja/pagamento"> <strong> Próximo </strong> </a> </div>');
                    $('#cadastro input').val("");
                    $('#cadastro input[type = submit]').val("CADASTRAR")
                    $('#loading').html('');
                    $('html, body').animate({scrollTop:500}, 'slow');
                }else{
                    $('#loading').html('');
                    $('#retorno').html(dados.message);
                    $('html, body').animate({scrollTop:500}, 'slow');
                }
            }
        });
    });
});

$(function(){
    $('#acha_cadastro').on('submit', function(e){
        e.preventDefault();

        if(!TestaCPF( $('#cpf_cad').val())){
            toastr.error ('CPF inválido!');
            return;
        }else{
            $('#error5').html('');
        }

        $.ajax({
            url: '/crie-sua-loja/verifica-cpf',
            type: 'POST',
            data: {
                cpf_cad: $('#cpf_cad').val()
            },
            dataType: 'JSON',
            beforeSend: function(){
                $('#loading').html('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"></div><span class="visually-hidden"> &nbsp;&nbsp; Carregando...</span></div>');
            },
            success:function(dados){
                if(dados.message == 1){
                   $('#loading').html('');
                   window.location.href = '/crie-sua-loja/pagamento';
                }else{
                    $('#loading').html('');
                    $('#retorno').html(dados.message);
                    $('html, body').animate({scrollTop:500}, 'slow');
                }
            }
        });

    });
});

$('#nome_usu').blur(function(){
    var nome = $('#nome_usu').val();
    var padrao = /[^a-zà-ú]/gi;

    var valida_nome = nome.match(padrao);

    if(valida_nome || !nome){
        $('#error1').html('<p style="color: #fa3200;font-weight: bolder;">Nome em branco ou com caracteres inválidos!</p>');
        return;
    }else{
        $('#error1').html('');
    }

});

$('#rep_senha').blur(function(){
    if( $('#senha').val().length < 6 || $('#rep_senha').val().length < 6 ){
        $('#error14').html('<p style="color: #fa3200;font-weight: bolder;">Senhas menor que seis caracteres!</p>');
        return;
    }else{
        $('#error14').html('');
    }

    if( $('#senha').val() != $('#rep_senha').val() ){
        $('#error14').html('<p style="color: #fa3200;font-weight: bolder;">Senhas não batem!</p>');
        return;
    }else{
        $('#error14').html('');
    }
});

$('#sobrenome_usu').blur(function(){
    var nome = $('#sobrenome_usu').val();
    var padrao = /[^a-zà-ú]/gi;

    var valida_nome = nome.match(padrao);

    if(valida_nome || !nome){
        $('#error2').html('<p style="color: #fa3200;font-weight: bolder;">Sobrenome em branco ou com caracteres inválidos!</p>');
        return;
    }else{
        $('#error2').html('');
    }

});

$('#email_usu').blur(function(){

    if( $('#email_usu').val() == '' ){
        $('#error3').html('<p style="color: #fa3200;font-weight: bolder;">E-mail em branco!</p>');
        return;
    }else{
        $('#error3').html('');
    }

});

$('#celular').blur(function(){

    if( $('#celular').val() == '' ){
        $('#error4').html('<p style="color: #fa3200;font-weight: bolder;">Celular em branco!</p>');
        return;
    }else{
        $('#error4').html('');
    }

});

$('#cpf_usu').blur(function(){

    if( $('#cpf_usu').val() == '' ){
        $('#error5').html('<p style="color: #fa3200;font-weight: bolder;">CPF em branco!</p>');
        return;
    }else{
        $('#error5').html('');
    }

    if(!TestaCPF($('#cpf_usu').val())){
        $('#error5').html('<p style="color: #fa3200;font-weight: bolder;">CPF inválido!</p>');
        return;
    }else{
        $('#error5').html('');
    }
});

$('#data_nasc').blur(function(){

    if( $('#data_nasc').val() == '' ){
        $('#error6').html('<p style="color: #fa3200;font-weight: bolder;">Data de nascimento em branco!</p>');
        return;
    }else{
        $('#error6').html('');
    }

});

$('#rua_usu').blur(function(){

    if( $('#rua_usu').val() == '' ){
        $('#error7').html('<p style="color: #fa3200;font-weight: bolder;">Rua em branco!</p>');
        return;
    }else{
        $('#error7').html('');
    }

});

$('#bairro_usu').blur(function(){

    if( $('#bairro_usu').val() == '' ){
        $('#error8').html('<p style="color: #fa3200;font-weight: bolder;">Bairro em branco!</p>');
        return;
    }else{
        $('#error8').html('');
    }

});

$('#num_usu').blur(function(){

    if( $('#num_usu').val() == '' ){
        $('#error9').html('<p style="color: #fa3200;font-weight: bolder;">Número em branco!</p>');
        return;
    }else{
        $('#error9').html('');
    }

});

$('#cep_usu').blur(function(){

    if( $('#cep_usu').val() == '' ){
        $('#error10').html('<p style="color: #fa3200;font-weight: bolder;">CEP em branco!</p>');
        return;
    }else{
        $('#error10').html('');
    }

});

$('#cidade_usu').blur(function(){

    if( $('#cidade_usu').val() == '' ){
        $('#error15').html('<p style="color: #fa3200;font-weight: bolder;">Cidade em branco!</p>');
        return;
    }else{
        $('#error15').html('');
    }

});

$('#subdominio').blur(function(){

    if( $('#subdominio').val() == '' ){
        $('#error12').html('<p style="color: #fa3200;font-weight: bolder;">Subdomínio em branco!</p>');
        return;
    }else{
        $('#error12').html('');
    }

    $.ajax({
        url: '/crie-sua-loja/consulta-sub',
        type: 'POST',
        data:{
            sub: $('#subdominio').val()
        },
        dataType: 'JSON',
        success:function(json){
            if(json.message){
                $('#error12').html('<p style="color: #fa3200;font-weight: bolder;">Subdomínio já existe, informe outro!</p>');
                return;        
            }else{
                $('#error12').html('');
            }
        }
    })

});

$('#nome_fan').blur(function(){

    if( $('#nome_fan').val() == '' ){
        $('#error13').html('<p style="color: #fa3200;font-weight: bolder;">Nome fantasia em branco!</p>');
        return;
    }else{
        $('#error13').html('');
    }

});

$('#login').blur(function(){

    if( $('#login').val() == '' ){
        $('#error16').html('<p style="color: #fa3200;font-weight: bolder;">Login em branco!</p>');
        return;
    }else{
        $.ajax({
            url: '/crie-sua-loja/consulta-login',
            type: 'POST',
            data:{
                login:$('#login').val()
            },
            dataType: 'JSON',
            success:function(json){
                if(json.message){
                    $('#error16').html('<p style="color: #fa3200;font-weight: bolder;">Já existe esse login, informe outro!</p>');
                    return;            
                }else{
                    $('#error16').html('');
                }
            }
        });
    }

});

$(document).ready(function () {
    $('#cpf_usu').mask("00000000000");
});

$(document).ready(function () {
    $('#cpf_cad').mask("00000000000");
});

$(document).ready(function () {
    $('#data_nasc').mask('00/00/0000')
});

$(document).ready(function () {
    $('#celular').mask('(00)00000-0000')
});

$(document).ready(function () {
    $('#cnpj').mask('00000000000000')
});   

$(document).ready(function () {
    $('#cep_usu').mask('00000-000')
});  

function TestaCPF(strCPF) {
    var Soma;
    var Resto;
    Soma = 0;
  if (strCPF == "00000000000") return false;

  if(
     strCPF == "00000000000" ||
     strCPF == "11111111111" ||
     strCPF == "22222222222" ||
     strCPF == "33333333333" ||
     strCPF == "44444444444" ||
     strCPF == "55555555555" ||
     strCPF == "66666666666" ||
     strCPF == "77777777777" ||
     strCPF == "88888888888" ||
     strCPF == "99999999999" 
){
    return false;
  }

  for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
  Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;

  Soma = 0;
    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
    return true;
}