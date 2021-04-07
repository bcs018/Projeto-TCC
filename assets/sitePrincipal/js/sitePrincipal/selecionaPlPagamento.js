$('#1').on('click',function(){
    if(confirm("Deseja realmente assinar o plano Free?")){
        window.location.href = '/crie-sua-loja/obrigado';
    }
});

$('#2').on('click',function(){
    //$('#plan').val(2);
    //$("#exampleModal").modal('show');
    //window.location.href = '/crie-sua-loja/pagamento/boleto/checkout/2';

    $.ajax({
        url: '/crie-sua-loja/pagamento/boleto/checkout/2',
        type: 'POST',
        dataType: 'JSON',

        success:function(json){
            if(json.retorno){
                window.location.href = '/crie-sua-loja/obrigado/'.json.idAss;
            }
        }
    });
    

    
});

$('#3').on('click',function(){
    $('#plan').val(3);
    //$("#exampleModal").modal('show');
    window.location.href = '/crie-sua-loja/pagamento/boleto/checkout/3';

});