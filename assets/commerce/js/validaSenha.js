// Valida se as senhas batem na tela de edição de dados pessoais

$("#altSenhaRep").on('keyup', function(){
    if($("#altSenha").val() != $("#altSenhaRep").val()){
        $("#message").html('<div class="alert alert-danger" role="alert">Senhas não batem!</div>');
        $("#message2").html('<div class="alert alert-danger" role="alert">Senhas não batem!</div>');
    }else{
        $("#message").html('<div class="alert alert-success" role="alert">Senhas OK!</div>');
        $("#message2").html('<div class="alert alert-success" role="alert">Senhas OK!</div>');
    }
})