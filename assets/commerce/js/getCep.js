$('#cep').on('keyup', function(){

    if($('#cep').val().length == 9){
        var cep = $("#cep").val().split("-");
        cep = cep[0]+cep[1];
    
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

});
 