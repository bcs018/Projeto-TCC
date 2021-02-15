$(function(){
    $('input[name=n_card]').on('keyup', function(e){
        if($(this).val().length == 6){

            PagSeguroDirectPayment.getBrand({
                cardBin: $(this).val(),
                success:function(r){
                    window.bandeira = r.brand.name;
                    var cvvLimit = r.brand.cvvSize;

                    $('input[name=cd_seg]').attr('maxlength', cvvLimit);

                    
                },
                error:function(r){

                },
                complete:function(r){}
            });
        }
    });
});