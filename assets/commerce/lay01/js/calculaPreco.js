$(document).ready(function(){
    $(".product-quantity").find("input[name=qtd]").click(function(){
        
        id = $(this).attr("id");
        qt = $('#'+id).val();

        $.ajax({
            url: '/calcular-preco',
            type: 'POST',
            dataType: 'JSON',
            data: { 'id':id, 'qt':qt },
            success:function(ret){
                $('#v'+id).html('R$ '+ret.valor);
            }
        })

        $.ajax({
            url: '/calcular-subtotal',
            type: 'POST',
            dataType: 'JSON',
            success:function(ret){
                $('#subtot').html('R$ '+ret.valor);
                $('#subtotHead').html('R$ '+ret.valor)
            }
        })
    })
})