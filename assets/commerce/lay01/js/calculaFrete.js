$(function(){
    $('#frete').on('submit', function(e){
        e.preventDefault();
        cep = $('#cepCalc').val();
        id  = $('#id').val();
        flag = 0;
        if( $('#flag').val() == '1'){
            flag = $('#flag').val();
        }else{
            flag = '0';
        }

        if(cep == ''){
            $.ajax({
                url: '/deleta-sessao-frete',
                type: 'POST',
                dataType: 'JSON',
                success:function(ret){
                    console.log(ret.deletado)
                }
            })
            calcSubtotal();
            $('#calcfrete').html('CEP não informado!');
            return
        }
         
        $.ajax({
            url: '/calcula-frete',
            type: 'POST',
            data: {cep:cep, id:id, flag:flag},
            dataType: 'JSON',
            success:function(ret){
                if(ret.erro != 0){
                    $('#calcfrete').html('Ocorreu erro ao calcular o frete, combine com o vendedor!');
                }else{
                    $('#calcfrete').html('R$ '+ret.preco+ ' Prazo: '+ret.data+' dia(s) para o CEP: '+ret.cep);
                    $('#cep').val(cep.substr(0,5)+'-'+cep.substr(5,7));                    
                    $.ajax({
                        url: '/consulta-cep',
                        type: 'POST',
                        data: {
                            cep:cep
                        },
                        dataType: 'json',
                        success: function(json){
                            $('#bairro').val(json.bairro);
                            $('#rua').val(json.logradouro);
                            $("#estado option:contains("+json.uf+")").prop({selected: true});
                            $('#cidade').val(json.localidade);
                            $('#complemento').val(json.complemento);
                        }
                    });
                }
                //console.log(ret.erro)
                // console.log()
                // console.log(ret.data)
                if(flag != '1'){
                    calcSubtotal();
                }
            }
        })
    })
})

function calcSubtotal(){
    $.ajax({
        url: '/calcular-subtotal',
        type: 'POST',
        dataType: 'JSON',
        success:function(ret){
            $('#subtot').html('R$ '+ret.subtotal);
            $('#subtotHead').html('R$ '+ret.total)
            $('#totalfinal').html('R$ '+ret.total)
            $('#plan').val(ret.total)
        }
    })
}