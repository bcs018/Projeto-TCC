$('#pagar').on('click', function(e){
    e.preventDefault();

    $.ajax({
        url: '/verifica-log-usuario',
        dataType: 'JSON',
        type: 'POST',
        success:function(ret){
            if(ret.log == false){
                window.location.href = '/login';
            }else{
                $('#exampleModal').modal('show');
                // $('#exampleModal').on('show.bs.modal', function (event) {

                // // })
            }
        }
    })
})