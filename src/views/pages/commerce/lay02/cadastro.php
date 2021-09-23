<?php $render('commerce/lay02/header', ['title' => $dados['nome_fantasia'] . ' | Home', 'layout' => $dados, 'carrinho' => $carrinho]); ?>

<section class="bg-img1 txt-center p-lr-15 p-tb-92"
    style="background-image: url('<?php echo BASE_ASS_C; ?>lay02/images/bg_cads2.jpg');">
    <h2 class="ltext-105 cl0 txt-center">
        Cadastre-se
    </h2>
</section>

<div style="margin: 10%;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <center>
                    <h4>Informe seus dados</h4>
                </center>
                <br><br>
                <div id="message">
                    <?php 
                    if(isset($_SESSION['message'])){
                        echo $_SESSION['message'].'<br>';
                        unset($_SESSION['message']);
                    }
                    ?>
                </div>
                <form action="/cadastrar-usuario" method="POST">
                    <div class="col-md-12 space">
                        <label for="nome" class="form-label">Nome:</label>
                        <input type="text" name="nome" id="nome" class="form-control">
                    </div>
                    <br>
                    <div class="col-md-12 space">
                        <label for="sobrenome" class="form-label">Sobrenome:</label>
                        <input type="text" name="sobrenome" id="sobrenome" class="form-control">
                    </div>
                    <br>
                    <div class="col-md-12 space">
                        <label for="cpf" class="form-label">CPF:</label>
                        <input type="text" name="cpf" id="cpf" class="form-control">
                    </div>
                    <br>
                    <div class="col-md-12 space">
                        <label for="email" class="form-label">E-mail:</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>
                    <br>
                    <div class="col-md-12 space">
                        <label for="cel" class="form-label">Celular:</label>
                        <input type="text" name="cel" id="cel" class="form-control">
                    </div>
                    <br>
                    <div class="col-md-12 space">
                        <label for="login" class="form-label">Login:</label>
                        <input type="text" name="login" id="login" class="form-control">
                    </div>
                    <br>
                    <div class="col-md-12 space">
                        <label for="altSenha" class="form-label">Senha:</label>
                        <input type="password" name="altSenha" id="altSenha" class="form-control">
                        <div class="valid-feedback">
                            Mínimo 6 caracteres!
                        </div>
                    </div>
                    <br>
                    <div class="col-md-12 space">
                        <label for="altSenhaRep" class="form-label">Repita a Senha:</label>
                        <input type="password" name="altSenhaRep" id="altSenhaRep" class="form-control">
                    </div>

                    <br>
                    <div class="col-md-12" id="message"></div>
                    <br>

                    <div id="message2"></div>

                    <div class="col-md-12 space text-right">
                        <br>
                        <button type="submit" class="flex-c-m stext-101 cl0 size-107 bgbutton bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
							Cadastrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $render('commerce/lay02/footer', ['dados' => $dados]); ?>

<script type="text/javascript">
    $('#cpf').mask("000.000.000-00");
    $('#cel').mask("(00)00000-0000");
</script>