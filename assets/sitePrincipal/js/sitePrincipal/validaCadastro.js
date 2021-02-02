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