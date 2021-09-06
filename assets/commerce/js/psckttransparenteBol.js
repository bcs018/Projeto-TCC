$(function(){
    $('.finalizar').on('click', function(){
        //Pega o id da transação
        //var id = PagSeguroDirectPayment.getSenderHash();
        

        PagSeguroDirectPayment.onSenderHashReady(function(r){
            if(r.status == 'error') {
                console.log(r.message);
                return false;
            }
             id = r.senderHash; 
        });

        // var cupom = $('#cupom').val();

        //Finalizar o pagamento via ajax
        $.ajax({
            url: '/checkoutBol',
            type: 'POST',
            data:{
                id:id,
            },
            dataType:'json',
            beforeSend: function(){
                $('#loading').html('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"></div><span class="visually-hidden"> &nbsp;&nbsp; Finalizando pagamento...</span></div>');
            },
            success:function(json){
                $('#teste').html(json.code+'</br>'+json.link);
                // if(json.error == true){
                //     console.log(json.calculo)
                //     $('#loading').html('<div class="alert alert-danger" role="alert">001 - Houve erro durante o pagamento, tente novamente atualizando a pagina!</div>');
                //     return;
                // }
                // window.location.href = '/pagamento/concluido/'+json.id_compra;
                //$('#loading').html('<div class="alert alert-success" role="alert">Pagamento finalizado com sucesso</div>');
            },
            error:function(json){
                $('#loading').html('<div class="alert alert-danger" role="alert">002 - Houve erro durante o pagamento, tente novamente atualizando a pagina!</div>');
            }
        });
    });
});