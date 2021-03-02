$("#cep_usu").blur(function(){
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
            
        }
    });

});
