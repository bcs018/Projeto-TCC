<?php $render('commerce/lay01/header', ['title' => $dados['nome_fantasia'] . ' | Finalização da compra', 'layout' => $dados]); ?>

<div class="product-big-title-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-bit-title text-center">
                    <h2>Finalização da compra</h2>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="single-product-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            </div>
            <div class="col-md-4">
                <label for="formGroupExampleInput" class="form-label">Número do cartão</label>
                <input type="number" class="form-control" id="formGroupExampleInput" placeholder="Número do cartão">
                <br>

                <label for="formGroupExampleInput2" class="form-label">Número de parcelas</label>
                <select name="parc" id="parc" class="form-control"></select>
                <br>

                <label for="formGroupExampleInput" class="form-label">Código de segurança</label>
                <input type="number" class="form-control" id="formGroupExampleInput" placeholder="Código de segurança">
                <br>

                <label for="formGroupExampleInput" class="form-label">Mês e ano do vencimento</label>
                <div class="row">
                    <div class="col-md-6">
                        <select name="cartao_mes" id="cartao_mes" class="form-control">
                            <?php for($q=1; $q<=12; $q++): ?>
                            <option><?php echo ($q<10)?'0'.$q:$q; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <select name="cartao_ano" id="cartao_ano" class="form-control">
                            <?php $ano = intval(date('Y')); ?>
                            <?php for($q=$ano; $q<=($ano+30); $q++): ?>
                            <option><?php echo $q; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div> <br>

                <label for="formGroupExampleInput" class="form-label">Nome impresso no cartão</label>
                <input type="number" class="form-control" id="formGroupExampleInput" placeholder="Nome impresso no cartão">
                <br>

                <label for="formGroupExampleInput" class="form-label">CPF do titular do cartão</label>
                <input type="number" class="form-control" id="formGroupExampleInput" placeholder="CPF do titular do cartão">
                <br>

                
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-7">
                <h4>Produtos selecionados</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Primeiro</th>
                                <th scope="col">Último</th>
                                <th scope="col">Nickname</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $render('commerce/lay01/footer', ['dados' => $dados]); ?>