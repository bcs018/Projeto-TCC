$(function(){
    $('#detalheProduto').on('submit', function(e){
        e.preventDefault();

        id        = $('#id').val();
        nomeProd  = $('#nomeProd').val();
        descProd  = $('#descProd').val();
        categoria = $('#categoria').val();
        marca     = $('#marca').val();
        estoque   = $('#estoque').val();
        preco     = $('#preco').val();
        precoAnt  = $('#precoAnt').val();
        promo     = $('input[name=promo]:checked').val();
        novo      = $('input[name=novo]:checked').val();
        peso        = $('#precoAnt').val();
        altura      = $('#precoAnt').val();
        largura     = $('#precoAnt').val();
        comprimento = $('#precoAnt').val();
        diametro    = $('#precoAnt').val();


        if(nomeProd == '' || estoque == '' || preco == '' || peso == '' || altura == '' || largura == '' || comprimento == '' || diametro == ''){
            message = '<br><div class="alert alert-danger" role="alert">Existem campos não preenchidos!</div>';

            $('#message').html(message);
            $('html, body').animate({scrollTop:0}, 'slow');

            return;
        }

        if(isNaN(estoque) || estoque <= 0){
            message = '<br><div class="alert alert-danger" role="alert">Estoque não numérico ou menor ou igual a ZERO!</div>';

            $('#message').html(message);
            $('html, body').animate({scrollTop:0}, 'slow');

            return;
        }

        if((promo < 0 || promo > 1) || (novo < 0 || novo > 1) || isNaN(promo) || isNaN(novo)){
            message = '<br><div class="alert alert-danger" role="alert">Houve um problema ao adicionar o produto, atualize a página e tente novamente!</div>';

            $('#message').html(message);
            $('html, body').animate({scrollTop:0}, 'slow');

            return;
        }

        $.ajax({
            url: '/admin/painel/cadastrar-produtos/first',
            type: 'POST',
            data:{
                nomeProd    ,
                descProd    ,
                categoria   ,
                marca       ,
                estoque     ,
                preco       ,
                precoAnt    ,
                promo       ,
                novo        ,
                id          ,
                peso        ,
                altura      ,
                largura     ,
                comprimento ,
                diametro
            },
            dataType: 'JSON',
            success:function(dados){
                if(dados.insercao == false){
                    $('#message').html(dados.message);
                    $('html, body').animate({scrollTop:0}, 'slow');
                }else{
                    window.location.replace("/admin/painel/cadastrar-produtos/"+dados.id);
                }
            }
        });
    });
});