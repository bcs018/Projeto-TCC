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

        var numero = $('#n_card').val();
        var cvv = $('#cd_seg').val();
        var v_mes = $('#cartao_mes').val();
        var v_ano = $('#cartao_ano').val();

        var nome_card = $('#nome_card').val();
        var cpf_tit = $('#cpf_card').val();

        var parc = $('#parc').val().replace(',','');
        var cupom = $('#cupom').val();

        if(numero != '' && cvv != '' && v_mes != '' && v_ano != ''){

            PagSeguroDirectPayment.createCardToken({
                cardNumber:numero,
                brand:window.bandeira,
                cvv:cvv,
                expirationMonth:v_mes,
                expirationYear:v_ano,
                success:function(r){
                    window.cardToken = r.card.token;

                    //Finalizar o pagamento via ajax
                    $.ajax({
                        url: '/checkout',
                        type: 'POST',
                        data:{
                            id:id,
                            nome_card:nome_card,
                            cpf:cpf_tit,
                            cartao_token:window.cardToken,
                            parc:parc,
                            cupom:cupom
                        },
                        dataType:'json',
                        beforeSend: function(){
                            $('#loading').html('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"></div><span class="visually-hidden"> &nbsp;&nbsp; Finalizando pagamento...</span></div>');
                        },
                        success:function(json){
                            if(json.error == true){
                                console.log(json.calculo)
                                $('#loading').html('<div class="alert alert-danger" role="alert">001 - Houve erro durante o pagamento, tente novamente atualizando a pagina!</div>');
                                return;
                            }
                            window.location.href = '/pagamento/concluido/'+json.id_compra;
                            //$('#loading').html('<div class="alert alert-success" role="alert">Pagamento finalizado com sucesso</div>');
                        },
                        error:function(json){
                            $('#loading').html('<div class="alert alert-danger" role="alert">002 - Houve erro durante o pagamento, tente novamente atualizando a pagina!</div>');
                        }
                    });
                },
                error:function(r){
                    console.log(r);
                },
                complete:function(r){}
            });
        }else{
            toastr.error ('Preencha todos os campos!');
        }
    });

    $('input[name=n_card]').on('keyup', function(e){
        if($(this).val().length == 6){  
            PagSeguroDirectPayment.getBrand({
                cardBin: $(this).val(), 
                success:function(r){
                    window.bandeira = r.brand.name;
                    var cvvLimit = r.brand.cvvSize;

                    //Pegando parcelamento
                    PagSeguroDirectPayment.getInstallments({
                        //valor total
                        amount:$('#plan').val().replace(',',''),
                        //bandeira cartao
                        brand:window.bandeira,
                        //max de parcelas sem juros
                        maxInstallmentNoInterest:12,
                        success:function(r){
                            if(r.error == false){
                                var parc = r.installments[window.bandeira];
                                var html = '';

                                for(var i in parc){
                                    var optionValue = parc[i].quantity+';'+parc[i].installmentAmount+';';
                                    if(parc[i].interestFree == true){
                                        optionValue += 'true';
                                    }else{
                                        optionValue += 'false';
                                    }
                                    var total = parc[i].installmentAmount;
                                    var number = total.toFixed(2).replace(".",",");
                                    html += '<option value="'+optionValue+'">'+parc[i].quantity+'x de R$'+number+'</option>';
                                }

                                console.log(r);

                                $('select[name=parc]').html(html);
                            }
                        },
                        error:function(r){

                        },
                        complete:function(r){}

                    });
                    $('#brand').html(r.brand.name.toUpperCase())
                    // switch (r.brand.name) {
                    //     case 'visa':
                    //         $('#brand').html('<img src="/assets/sitePrincipal/images/card/visa.png" width="59" height="5">');
                    //         break;
                    //     case 'mastercard':
                    //         $('#brand').html('<img src="/assets/sitePrincipal/images/card/mastercard.png" width="105" height="29">');
                    //         break;
                    //     case 'elo':
                    //         $('#brand').html('<img src="/assets/sitePrincipal/images/card/elo.png" width="65" height="20">');
                    //         break;
                    //     case 'hipercard':
                    //         $('#brand').html('<img src="/assets/sitePrincipal/images/card/hipercard.png" width="56" height="25">');
                    //         break;
                    //     default:
                    //         $('#brand').html('<p>'+r.brand.name.toUpperCase()+'</p>');
                    //         break;
                    // }
                    $('input[name=cd_seg]').attr('maxlength', cvvLimit);                  
                },
                error:function(r){
                    console.log(r)
                },
                complete:function(r){}
            });
        }
    });
});