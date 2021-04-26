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
        type: 'GET',
        dataType: 'JSON',
        beforeSend: function(){
            $('#loading2').html('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"></div><span class="visually-hidden"> &nbsp;&nbsp; Aguarde...</span></div><br>');
        },

        success:function(json){
            if(json.retorno == 1){
                window.location.href = '/crie-sua-loja/obrigado/'+json.idAss;
            }else{
                window.location.href = '/crie-sua-loja/pagamento';
            }
                //console.log("TESTE");
                //window.location.href = '/crie-sua-loja/obrigado/'.json.idAss;
            
        }
    }); 
    

    
});

$('#3').on('click',function(){
    $('#plan').val(3);
    //$("#exampleModal").modal('show');
    window.location.href = '/crie-sua-loja/pagamento/boleto/checkout/3';

});