$(function(){
    $('#frete').on('submit', function(e){
        e.preventDefault();
        cep = $('#cep').val();

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
            data: {cep:cep},
            dataType: 'JSON',
            success:function(ret){
                $('#calcfrete').html('R$ '+ret.preco+ ' Prazo: '+ret.data+' dia(s) para o CEP: '+ret.cep);
                console.log(ret.erro)
                // console.log()
                // console.log(ret.data)
            }
        })

        calcSubtotal();
        
    })
})

function calcSubtotal(){
    console.log('Entri')
    $.ajax({
        url: '/calcular-subtotal',
        type: 'POST',
        dataType: 'JSON',
        success:function(ret){
            $('#subtot').html('R$ '+ret.subtotal);
            $('#subtotHead').html('R$ '+ret.subtotal)
            $('#totalfinal').html('R$ '+ret.total)
        }
    })
}