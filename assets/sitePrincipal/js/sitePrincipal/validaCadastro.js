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

$('#email').blur(function(){

    if( $('#sobrenome_usu').val() == '' ){
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
        $('#error9').html('<p style="color: #fa3200;font-weight: bolder;">Numero em branco!</p>');
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

$('#subdominio').blur(function(){

    if( $('#subdominio').val() == '' ){
        $('#error12').html('<p style="color: #fa3200;font-weight: bolder;">Subdominio em branco!</p>');
        return;
    }else{
        $('#error12').html('');
    }

});

$('#nome_fan').blur(function(){

    if( $('#nome_fan').val() == '' ){
        $('#error13').html('<p style="color: #fa3200;font-weight: bolder;">Nome fantasia em branco!</p>');
        return;
    }else{
        $('#error13').html('');
    }

});



