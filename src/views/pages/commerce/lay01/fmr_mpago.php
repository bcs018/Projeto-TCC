<form id="form-checkout">
    <label for="form-checkout__cardNumber" class="form-label">Número do cartão</label>
    <input class="form-control" type="text" name="cardNumber" id="form-checkout__cardNumber" /> <br>

    <label for="form-checkout__cardExpirationMonth" class="form-label">Mês e ano do vencimento</label>
    <input class="form-control" type="text" name="cardExpirationMonth" id="form-checkout__cardExpirationMonth" />
    <input class="form-control" type="text" name="cardExpirationYear" id="form-checkout__cardExpirationYear" /> <br>

    <label for="form-checkout__cardholderName" class="form-label">Nome impresso no cartão</label>
    <input class="form-control" type="text" name="cardholderName" id="form-checkout__cardholderName" /> <br>
    
    <label for="form-checkout__securityCode" class="form-label">Código de segurança</label>
    <input class="form-control" type="text" name="securityCode" id="form-checkout__securityCode" /> <br>

    <select class="form-control" name="issuer" id="form-checkout__issuer"></select> <br>

    <label for="form-checkout__identificationType" class="form-label">Tipo e número do documento</label>
    <select class="form-control" name="identificationType" id="form-checkout__identificationType"></select> <br>

    <input class="form-control" type="text" name="identificationNumber" id="form-checkout__identificationNumber" /> <br>
    
    <label for="parc" class="form-label">Número de parcelas</label>
    <select class="form-control" name="installments" id="form-checkout__installments"></select> <br>

    <button type="submit" id="form-checkout__submit">Finalizar Compra</button> <br><br><br>

    <div id="message"></div>

    <progress value="0" class="progress-bar">loading...</progress>
</form>