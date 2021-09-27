<?php $render("sitePrincipal/header_paineladm", ['title'=>'Painel administrativo - Clientes']); ?>

<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?php echo $titleView; ?></h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md">
            <?php foreach($clientes as $c): ?>
              <fieldset class="border p-2">
                  <div class="row">
                      <div class="col-5">
                          <p style="margin-bottom: 0px;"><strong>ID Cliente:  </strong><?php echo $c[0]; ?> </p>
                          <p style="margin-bottom: 0px;"><strong>Nome Loja: </strong><?php echo $c['nome_fantasia']; ?></p>
                          <p style="margin-bottom: 0px;"><strong>Nome Responsável: </strong><?php echo $c['nome'].' '.$c['sobrenome']; ?></p>
                          <p style="margin-bottom: 0px;"><strong>E-mail Responsável: </strong><?php echo $c['email']; ?></p>
                      </div>
                      
                        <div class="col"> 
                            <b><p style="margin-bottom: 0px;">Data cadastro: </b><?php echo date("d/m/Y", strtotime($c['data_cad'])); ?></p>
                            <b><p style="margin-bottom: 0px;">Plano: </b><?php echo $c['nome_plano']; ?></p>
                            <b><p style="margin-bottom: 0px;">Subdominio: </b><?php echo $c['sub_dominio']; ?></p>
                            <b><p style="margin-bottom: 0px;">Ativo: </b><?php echo($c['ativo']=='1')?'SIM':"NÃO"; ?></p>
                            <br>
                            <div class="row">
                              <div class="col col-lg-2">
                                <a id="i-<?php echo $c['usuario_id']; ?>" href="#">Inativar</a>
                              </div>
                              <div class="col col-lg-2">
                                <a id="a-<?php echo $c['usuario_id']; ?>" href="#">Ativar</a>
                                <!-- <input type="hidden" id="id" value="<?php echo $c['usuario_id'] ?>"> -->
                              </div>
                            </div>
                        </div>
                      
                  </div>
              </fieldset> <br>
            <?php endforeach; ?>

            </div>
        </div>
    </div>

</div>



<?php $render("sitePrincipal/footer_paineladm"); ?>

<script>

  $('a').click(function(){
    id = $(this).attr('id').split("-")

    if(id[0] == 'a'){
      $.confirm({
        title: 'Ativar cliente?',
        content: '',
        type: 'orange',
        buttons: {
            deleteUser: {
                text: 'Ativar',
                action: function () {
                  $.ajax({
                    url: '/ativar/cliente/'+id[1],
                    type: 'GET',
                    dataType: 'JSON',
                    success:function(r){
                      if(r.ret == true){
                        $.alert('Cliente ativado!');
                      }else{
                        $.alert('Ocorreu erro interno ao ativar cliente!');
                      }
                    }
                  })
                }
            },
            cancelar: {
                btnClass: 'btn-red any-other-class', // multiple classes.
            },
        }
      });
    }else{
      $.confirm({
          title: 'Inativar cliente?',
          content: '',
          type: 'orange',
          buttons: {
              deleteUser: {
                  text: 'Inativar',
                  action: function () {
                    $.ajax({
                      url: '/inativar/cliente/'+id[1],
                      type: 'GET',
                      dataType: 'JSON',
                      success:function(r){
                        if(r.ret == true){
                          $.alert('Cliente inativado!');
                        }else{
                          $.alert('Ocorreu erro interno ao inativar cliente!');
                        }
                      }
                    })
                  }
              },
              cancelar: {
                  btnClass: 'btn-red any-other-class', // multiple classes.
              },
          }
      });
    }
  });

</script>