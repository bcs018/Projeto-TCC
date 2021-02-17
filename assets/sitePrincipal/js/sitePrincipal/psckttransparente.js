$(function(){
    $('.finalizar').on('click', function(){
        //Pega o id da transação
        var id = PagSeguroDirectPayment.getSenderHash();

        var numero = $('#n_card').val();
        var cvv = $('#cd_seg').val();
        var v_mes = $('#cartao_mes').val();
        var v_ano = $('#cartao_ano').val();

        var nome_tit = $('#nome_card').val();
        var cpf_tit = $('#cpf_card').val();

        if(numero != '' && cvv != '' && v_mes != '' && v_ano != ''){
            alert("OLA");
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
                            nome_tit:nome_tit,
                            cpf:cpf_tit,
                            numero_card:numero,
                            cvv:cvv,
                            v_mes:v_mes,
                            v_ano:v_ano,
                            cartao_token:window.cardToken
                        },
                        dataType:'json',
                        success:function(json){

                        },
                        error:function(json){

                        }
                    });
                },
                error:function(r){
                    console.log(r);
                },
                complete:function(r){}
            });
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
                        amount:100,
                        //bandeira cartao
                        brand:window.bandeira,
                        //max de parcelas sem juros
                        maxInstallmentNoInterest:12,
                        success:function(r){
                            if(r.error == false){
                                var parc = r.installments[window.bandeira];
                                var html = '';

                                for(var i in parc){
                                    var optionValue = parc[i].quantity+';'+parc[i].installmentAmount;
                                    if(parc[i].interestFree == true){
                                        optionValue += ';true';
                                    }else{
                                        optionValue += ';false';
                                    }
                                    html += '<option value="'+optionValue+'">'+parc[i].quantity+'x de R$'+parc[i].installmentAmount+'</option>';
                                }

                                $('select[name=parc]').html(html);
                            }
                        },
                        error:function(r){

                        },
                        complete:function(r){}

                    });

                    switch (r.brand.name) {
                        case 'visa':
                            $('#error1').html('<img src="/assets/sitePrincipal/images/card/visa.png" width="59" height="15">');
                            break;
                        case 'mastercard':
                            $('#error1').html('<img src="/assets/sitePrincipal/images/card/mastercard.png" width="105" height="29">');
                            break;
                        case 'elo':
                            $('#error1').html('<img src="/assets/sitePrincipal/images/card/elo.png" width="65" height="20">');
                            break;
                        case 'hipercard':
                            $('#error1').html('<img src="/assets/sitePrincipal/images/card/hipercard.png" width="56" height="25">');
                            break;
                        default:
                            $('#error1').html('<p>'+r.brand.name.toUpperCase()+'</p>');
                            break;
                    }
                    $('input[name=cd_seg]').attr('maxlength', cvvLimit);

                    
                },
                error:function(r){

                },
                complete:function(r){}
            });
        }
    });
});