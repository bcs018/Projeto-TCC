$("#cep_usu").blur(function(){
    var cep = $("#cep_usu");
    cep = cep.split("-");
    cep = cep[0]+cep[1];

    console.log(cep);

});
