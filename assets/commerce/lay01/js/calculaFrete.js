$(function(){
    $('#frete').on('submit', function(e){
        e.preventDefault();
        cep = $('#cep').val();

        $.ajax({
            url: '/calcula-frete',
            type: 'POST',
            data: {cep:cep},
            dataType: 'JSON',
            success:function(ret){
                $('#calcfrete').html('R$ '+ret.preco+ ' Prazo: '+ret.data+' dia(s)');
                // console.log(ret.preco)
                // console.log()
                // console.log(ret.data)
            }
        })
    })
})