$('#1').on('click',function(){
    if(confirm("Deseja realmente assinar o plano Free?")){
        window.location.href = '/crie-sua-loja/obrigado';
    }
});

$('#2').on('click',function(){
    $('#plan').val(2);
    $("#exampleModal").modal('show');
});

$('#3').on('click',function(){
    $('#plan').val(3);
    $("#exampleModal").modal('show');
});