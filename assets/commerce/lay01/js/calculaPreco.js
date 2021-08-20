$(document).ready(function(){
    $(".product-quantity").find("input[name=qtd]").on("click",function(){
        
        id = $(this).attr("id");
        qt = $('#'+id).val();

        if(qt == 0){
            $(this).val(1);
            qt = 1;
        }

        $.ajax({
            url: '/calcular-preco',
            type: 'POST',
            dataType: 'JSON',
            data: { 'id':id, 'qt':qt },
            success:function(ret){
                $('#v'+id).html('R$ '+ret.valor);
            }
        })
        calcSubtotal()
        // $.ajax({
        //     url: '/calcular-subtotal',
        //     type: 'POST',
        //     dataType: 'JSON',
        //     success:function(ret){
        //         $('#subtot').html('R$ '+ret.subtotal);
        //         $('#subtotHead').html('R$ '+ret.total)
        //         $('#totalfinal').html('R$ '+ret.total)
        //     }
        // })
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
        }
    })
}