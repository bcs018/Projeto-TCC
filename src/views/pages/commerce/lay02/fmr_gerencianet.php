<label for="n_card" class="form-label">Número do cartão</label>
<input type="number" class="form-control" name="n_card" id="n_card" placeholder="Número do cartão"><br>

<label for="brand" class="form-label">Bandeira do cartão</label>
<select name="brand" id="brand" class="form-control">
    <option value="">Selecione a bandeira do seu cartão</option>
    <option value="mastercard">Master</option>
    <option value="visa">Visa</option>
    <option value="elo">Elo</option>
    <option value="hipercard">Hipercard</option>
    <option value="amex">Amex</option>   
    <option value="diners">Diners</option>   
</select>
<br>
<label for="parc" class="form-label">Número de parcelas</label>
<select name="parc" id="parc" class="form-control"></select>
<br>
<label for="cd_seg" class="form-label">Código de segurança</label>
<input type="number" class="form-control" name="cd_seg" id="cd_seg" placeholder="Código de segurança">
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
<label for="nome_card" class="form-label">Nome impresso no cartão</label>
<input type="text" value="" class="form-control" name="nome_card" id="nome_card"
    placeholder="Nome impresso no cartão">
<br>
<label for="cpf_card" class="form-label">CPF do titular do cartão</label>
<input type="number" value="" class="form-control" name="cpf_card" id="cpf_card"
    placeholder="CPF do titular do cartão">
<br>
<hr>
<div id="message"></div>

<button type="submit" id="finalizar" style="float: right;">Finalizar Compra</button> <br><br><br><br>
