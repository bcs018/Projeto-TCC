<?php $render('commerce/lay01/header', ['title' => $dados['nome_fantasia'] . ' | Finalização da compra', 'layout' => $dados]); ?>

<div class="product-big-title-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-bit-title text-center">
                    <h2>Shopping Cart</h2>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="single-product-area">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <label for="formGroupExampleInput" class="form-label">Example label</label>
                <input type="text" class="form-control" id="formGroupExampleInput"
                    placeholder="Example input placeholder"> <br>
                
                <label for="formGroupExampleInput2" class="form-label">Another label</label>
                <input type="text" class="form-control" id="formGroupExampleInput2"
                    placeholder="Another input placeholder">
            </div>

            <div class="col-md-8">
            
            </div>
        </div>
    </div>
</div>

<?php $render('commerce/lay01/footer', ['dados' => $dados]); ?>