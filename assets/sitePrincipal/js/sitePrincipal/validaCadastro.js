$('#nome_usu').blur(function(){
    var nome = $('#nome_usu').val();
    var padrao = /[^a-zà-ú]/gi;

    var valida_nome = nome.match(padrao);

    if(valida_nome || !nome){
        $('#error1').html('<p style="color: #fa3200;font-weight: bolder;">Nome em branco ou com caracteres inválidos!</p>');
        toastr.error ('Nome em branco!');
        return;
    }else{
        $('#error1').html('');
    }

});

$('#sobrenome_usu').blur(function(){
    var nome = $('#sobrenome_usu').val();
    var padrao = /[^a-zà-ú]/gi;

    var valida_nome = nome.match(padrao);

    if(valida_nome || !nome){
        $('#error2').html('<p style="color: #fa3200;font-weight: bolder;">Sobrenome em branco ou com caracteres inválidos!</p>');
        toastr.error ('Sobrenome em branco!');
        return;
    }else{
        $('#error2').html('');
    }

});

$('#email').blur(function(){

    if( $('#sobrenome_usu').val() == '' ){
        $('#error3').html('<p style="color: #fa3200;font-weight: bolder;">E-mail em branco!</p>');
        toastr.error ('E-mail em branco!');
        return;
    }else{
        $('#error3').html('');
    }

});

$('#celular').blur(function(){

    if( $('#celular').val() == '' ){
        $('#error4').html('<p style="color: #fa3200;font-weight: bolder;">Celular em branco!</p>');
        toastr.error ('Celular em branco!');
        return;
    }else{
        $('#error4').html('');
    }

});

$('#cpf_usu').blur(function(){

    if( $('#cpf_usu').val() == '' ){
        $('#error5').html('<p style="color: #fa3200;font-weight: bolder;">CPF em branco!</p>');
        toastr.error ('CPF em branco!');
        return;
    }else{
        $('#error5').html('');
    }

    if(!TestaCPF($('#cpf_usu').val())){
        $('#error5').html('<p style="color: #fa3200;font-weight: bolder;">CPF inválido!</p>');
        toastr.error ('CPF inválido!');
        return;
    }else{
        $('#error5').html('');
    }
});

$('#data_nasc').blur(function(){

    if( $('#data_nasc').val() == '' ){
        $('#error6').html('<p style="color: #fa3200;font-weight: bolder;">Data de nascimento em branco!</p>');
        toastr.error ('Data de nascimento em branco!');
        return;
    }else{
        $('#error6').html('');
    }

});

$('#rua_usu').blur(function(){

    if( $('#rua_usu').val() == '' ){
        $('#error7').html('<p style="color: #fa3200;font-weight: bolder;">Rua em branco!</p>');
        toastr.error ('Rua em branco!');
        return;
    }else{
        $('#error7').html('');
    }

});

$('#bairro_usu').blur(function(){

    if( $('#bairro_usu').val() == '' ){
        $('#error8').html('<p style="color: #fa3200;font-weight: bolder;">Bairro em branco!</p>');
        toastr.error ('Bairro em branco!');
        return;
    }else{
        $('#error8').html('');
    }

});

$('#num_usu').blur(function(){

    if( $('#num_usu').val() == '' ){
        $('#error9').html('<p style="color: #fa3200;font-weight: bolder;">Número em branco!</p>');
        toastr.error ('Número em branco!');
        return;
    }else{
        $('#error9').html('');
    }

});

$('#cep_usu').blur(function(){

    if( $('#cep_usu').val() == '' ){
        $('#error10').html('<p style="color: #fa3200;font-weight: bolder;">CEP em branco!</p>');
        toastr.error ('CEP em branco!');
        return;
    }else{
        $('#error10').html('');
    }

});

$('#subdominio').blur(function(){

    if( $('#subdominio').val() == '' ){
        $('#error12').html('<p style="color: #fa3200;font-weight: bolder;">Subdominio em branco!</p>');
        toastr.error ('Subdominio em branco!');
        return;
    }else{
        $('#error12').html('');
    }

});

$('#nome_fan').blur(function(){

    if( $('#nome_fan').val() == '' ){
        $('#error13').html('<p style="color: #fa3200;font-weight: bolder;">Nome fantasia em branco!</p>');
        toastr.error ('Nome fantasia em branco!');
        return;
    }else{
        $('#error13').html('');
    }

});

$(document).ready(function () {
    $('#cpf_usu').mask("00000000000");
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