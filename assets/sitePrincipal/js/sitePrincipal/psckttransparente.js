$(function(){
    $('.finalizar').on('click', function(){
        var numero = $('#n_card').val();
        var cvv = $('#cd_seg').val();
        var v_mes = $('#cartao_mes').val();
        var v_ano = $('#cartao_ano').val();

        if(numero != '' && cvv != '' && v_mes != '' && v_ano != ''){
            PagSeguroDirectPayment.createCardToken({
                cardNumber:numero,
                brand:window.cardBrand,
                expirationMonth:v_mes,
                expirationYear:v_ano,
                success:function(r){

                },
                error:function(r){

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
                        brand:window.cardBrand,
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