<?php $render('sitePrincipal/header', ['title'=>'BW Commerce | Pagamento']); ?>

<section class="hero-wrap hero-wrap-2" style="background-image: url('<?php echo BASE_ASS; ?>images/pg1.jpg');"
    data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end">
            <div class="col-md-9 ftco-animate pb-5">
                <p class="breadcrumbs mb-2"><span class="mr-2">Home &nbsp;|</span> <span>Crie sua loja &nbsp;| &nbsp;</span> <span>Pagamento</span> </p>
                <h1 class="mb-0 bread">Pagamento</h1>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="wrapper">
                    <div class="row no-gutters justify-content-center">
                        <div class="col-lg col-md-7 order-md-last d-flex align-items-stretch">
                            <div class="contact-wrap w-100 p-md-5 p-4">
                                <h1 class="mb-4">Será uma honra ter você como cliente <?php echo $_SESSION['person']['name']; ?></h1>
                                <br>
                                <h3 class="mb-4">Escolha um de nossos planos que mais lhe agrada!</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section bg-light">
		<div class="container">
			<div class="row justify-content-center pb-5 mb-3">
				<div class="col-md-7 heading-section text-center ftco-animate">
					<span class="subheading">Preço &amp; Planos</span>
					<h2>Abaixo nossos pacotes</h2>
				</div>
			</div>
			<div class="row justify-content-center">

				<?php foreach($planos as $plano): ?>
				<div class="col-md-6 col-lg-3 ftco-animate" id="margin_exp">
					<div class="block-7">
						<div class="text-center">
							<span class="excerpt d-block"><?php echo $plano['nome_plano']; ?></span>
							<span class="price"><sup>R$</sup> <span class="number"><?php echo $plano['preco']; ?></span> <sub>/mês</sub></span>
							
							<?php $descricoes = explode(";", $plano['descricao_plano']); 
								echo '<ul class="pricing-text mb-5">';
								foreach($descricoes as $descricao): ?>
									<li><span class="fa fa-check mr-2"></span><?php echo $descricao; ?></li>
								<?php endforeach; ?>
							</ul>
							<a href="#" class="btn btn-primary d-block px-2 py-3">Comprar</a>
						</div>
					</div>
				</div>
				<?php endforeach; ?>

			</div>
		</div>
	</section>
    <br><br><br><br>
<?php $render('sitePrincipal/footer')?>

