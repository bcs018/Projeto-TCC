<label for="n_card" class="form-label">Número do cartão</label>
<input type="number" class="form-control" name="n_card" id="n_card" placeholder="Número do cartão">
<div id="brand"></div>
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
<input type="text" value="BRUNO C SILVA" class="form-control" name="nome_card" id="nome_card"
    placeholder="Nome impresso no cartão">
<br>
<label for="cpf_card" class="form-label">CPF do titular do cartão</label>
<input type="password" value="38663382871" class="form-control" name="cpf_card" id="cpf_card"
    placeholder="CPF do titular do cartão">
<br>
<hr>

<button type="submit" class="flex-c-m stext-101 cl0 size-107 bgbutton bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10" id="finalizar" style="float: right;">Finalizar Compra</button> <br><br><br><br>
