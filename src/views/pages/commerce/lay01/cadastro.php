<?php $render('commerce/lay01/header', ['title' => $dados['nome_fantasia'] . ' | Cadastro', 'layout' => $dados]); ?>

<div class="product-big-title-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-bit-title text-center">
                    <h2>Cadastre-se</h2>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="single-product-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-content-right">
                    <div class="woocommerce">
                        <div id="message">
                            <?php 
                            if(isset($_SESSION['message'])){
                                echo $_SESSION['message'];
                                unset($_SESSION['message']);
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <h3>Informe seus dados</h3><br>
            </div>
            <form action="/cadastrar-usuario" method="POST">
                <div class="col-md-6 space">
                    <label for="nome" class="form-label">Nome:</label>
                    <input type="text" name="nome" id="nome" class="form-control">
                </div>

                <div class="col-md-6 space">
                    <label for="sobrenome" class="form-label">Sobrenome:</label>
                    <input type="text" name="sobrenome" id="sobrenome" class="form-control">
                </div>

                <div class="col-md-6 space">
                    <label for="cpf" class="form-label">CPF:</label>
                    <input type="text" name="cpf" id="cpf" class="form-control">
                </div>

                <div class="col-md-6 space">
                    <label for="email" class="form-label">E-mail:</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>

                <div class="col-md-6 space">
                    <label for="cel" class="form-label">Celular:</label>
                    <input type="text" name="cel" id="cel" class="form-control">
                </div>

                <div class="col-md-6 space">
                    <label for="login" class="form-label">Login:</label>
                    <input type="text" name="login" id="login" class="form-control">
                </div>

                <div class="col-md-6 space">
                    <label for="altSenha" class="form-label">Senha:</label>
                    <input type="password" name="altSenha" id="altSenha" class="form-control">
                    <div class="valid-feedback">
                        Mínimo 6 caracteres!
                    </div>
                </div>

                <div class="col-md-6 space">
                    <label for="altSenhaRep" class="form-label">Repita a Senha:</label>
                    <input type="password" name="altSenhaRep" id="altSenhaRep" class="form-control">
                </div>

                <br>
                <div class="col-md-12" id="message"></div>
                <br>

                <div class="col-md-12 space text-right">
                    <br>
                    <button type="submit">Cadastrar</button>
                </div>

            </form>
        </div>
    </div>
</div>

<?php $render('commerce/lay01/footer', ['dados' => $dados]); ?>

<script type="text/javascript">
    $('#cpf').mask("000.000.000-00");
    $('#cel').mask("(00)00000-0000");
</script>