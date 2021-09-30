<form action="/checkout_mpBol" method="post" id="paymentForm">
    <h3>Forma de Pagamento</h3><br><br>
    <div>
        <select class="form-control" class="form-control" id="paymentMethod" name="paymentMethod">
            <option>Selecione uma forma de pagamento</option>

            <!-- Create an option for each payment method with their name and complete the ID in the attribute 'value'. -->
            <option value="ticket" selected>Boleto</option>
        </select>
    </div> <br><br>
    <h3>Detalhe do comprador</h3>
    <div>
        <div>
            <label for="payerFirstName">Nome</label>
            <input class="form-control" id="payerFirstName" name="payerFirstName" type="text" value="Bruno"></select><br>
        </div>
        <div>
            <label for="payerLastName">Sobrenome</label>
            <input class="form-control" id="payerLastName" name="payerLastName" type="text" value="Cesar"></select><br>
        </div>
        <div>
            <label for="payerEmail">E-mail</label>
            <input class="form-control" id="payerEmail" name="payerEmail" type="text" value="test_user_83666516@testuser.com"></select><br>
        </div>
        <!-- <div>
            <label for="docType">Tipo de documento</label>
            <select class="form-control" id="docType" name="docType" data-checkout="docType" type="text"></select><br>
        </div>
        <div>
            <label for="docNumber">Número do documento</label>
            <input class="form-control" id="docNumber" name="docNumber" data-checkout="docNumber" type="text" /><br>
        </div> -->
    </div>

    <div>
        <div>
            <input type="hidden" name="transactionAmount" id="transactionAmount" value="100" />
            <input type="hidden" name="productDescription" id="productDescription" value="Nome do Produto" />
            <br>
            <button class="flex-c-m stext-101 cl0 size-107 bgbutton bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10" type="submit">Gerar boleto</button><br><br>
            <br>
        </div>
    </div>
</form>