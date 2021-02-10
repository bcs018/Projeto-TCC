$('#n_card').blur(function(){
    if($('#n_card').val() == ''){
        $('#error1').html('<p style="color: #fa3200;font-weight: bolder;">Número de cartão em branco!</p>');
        toastr.error ('Número de cartão em branco!');
        return;

    }
});

$('#nome_card').blur(function(){
    if($('#nome_card').val() == ''){
        $('#error2').html('<p style="color: #fa3200;font-weight: bolder;">Nome em branco!</p>');
        toastr.error ('Nome em branco!');
        return;

    }
});

$('#dt_ven').blur(function(){
    if($('#dt_ven').val() == ''){
        $('#error3').html('<p style="color: #fa3200;font-weight: bolder;">Data de vencimento em branco!</p>');
        toastr.error ('Data de vencimento em branco!');
        return;

    }
});

$('#cd_seg').blur(function(){
    if($('#cd_seg').val() == ''){
        $('#error4').html('<p style="color: #fa3200;font-weight: bolder;">Código de segurança em branco!</p>');
        toastr.error ('Código de segurança em branco!');
        return;
    }
}); 

$('#cpf_card').blur(function(){
    if($('#cpf_card').val() == ''){
        $('#error5').html('<p style="color: #fa3200;font-weight: bolder;">CPF em branco!</p>');
        toastr.error ('CPF em branco!');
        return;
    }
});