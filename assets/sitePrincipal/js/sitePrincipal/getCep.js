$('#cep_usu').on('keyup', function(){

    if($('#cep_usu').val().length == 9){
        var cep = $("#cep_usu").val().split("-");
        cep = cep[0]+cep[1];
    
        $.ajax({
            url: '/consulta-cep',
            type: 'POST',
            data: {
                cep:cep
            },
            dataType: 'json',
            success: function(json){
                $('#bairro_usu').val(json.bairro);
                $('#rua_usu').val(json.logradouro);
                $('#estado_usu option:selected').text(json.uf);
                $('#cidade_usu').val(json.localidade);
                $('#complemento').val(json.complemento);
            }
        });
    }

});
