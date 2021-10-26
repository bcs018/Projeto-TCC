<?php
use \src\models\commerce\Carrinho;
use src\controllers\commerce\CategoriaController;

$carr = new Carrinho;
$valores = $carr->somaValor();
if(!$valores)$valores['total'] = '0,00';

$cat = new CategoriaController;

$cats = $cat->listaCategorias();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title><?php echo $title; ?></title>
	<meta charset="UTF-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php if(isset($_SESSION['ico'])): ?>
        <link rel="shortcut icon" href="<?php echo BASE_ASS_C; ?>images_commerce/<?php echo $_SESSION['ico']; ?>">
    <?php endif; ?>

	<link rel="stylesheet" type="text/css" href="<?php //echo BASE_ASS_C; ?>/assets/commerce/lay02/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php //echo BASE_ASS_C; ?>/assets/commerce/lay02/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php //echo BASE_ASS_C; ?>/assets/commerce/lay02/fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="<?php //echo BASE_ASS_C; ?>/assets/commerce/lay02/fonts/linearicons-v1.0.0/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="<?php //echo BASE_ASS_C; ?>/assets/commerce/lay02/vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="<?php //echo BASE_ASS_C; ?>/assets/commerce/lay02/vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="<?php //echo BASE_ASS_C; ?>/assets/commerce/lay02/vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="<?php //echo BASE_ASS_C; ?>/assets/commerce/lay02/vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="<?php //echo BASE_ASS_C; ?>/assets/commerce/lay02/vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="<?php //echo BASE_ASS_C; ?>/assets/commerce/lay02/vendor/slick/slick.css">
	<link rel="stylesheet" type="text/css" href="<?php //echo BASE_ASS_C; ?>/assets/commerce/lay02/vendor/MagnificPopup/magnific-popup.css">
	<link rel="stylesheet" type="text/css" href="<?php //echo BASE_ASS_C; ?>/assets/commerce/lay02/vendor/perfect-scrollbar/perfect-scrollbar.css">
	<link rel="stylesheet" type="text/css" href="<?php //echo BASE_ASS_C; ?>/assets/commerce/lay02/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?php //echo BASE_ASS_C; ?>/assets/commerce/lay02/css/main.css">
<!--===============================================================================================-->
	<style>
		ins{text-decoration: none;}
		.bg3 {background-color: <?php echo $layout['cor_rodape']; ?>;}
		.bgbutton {background-color: #545454;}
		.hov-cl1:hover {color: <?php echo $layout['cor']; ?>;}
		.hov-bg1:hover {background-color: <?php echo $layout['cor']; ?>;} 
		.loader05 {
			width: 56px;
			height: 56px;
			border: 4px solid <?php echo $layout['cor']; ?>;
			border-radius: 50%;
			position: relative;
			animation: loader-scale 1s ease-out infinite;
			top: 50%;
			margin: -28px auto 0 auto; 
		}
		.btn-back-to-top {
			display: none;
			position: fixed;
			width: 40px;
			height: 38px;
			bottom: 0px;
			right: 40px;
			background-color: <?php echo $layout['cor']; ?>;
			opacity: 0.5;
			justify-content: center;
			align-items: center;
			z-index: 1000;
			cursor: pointer;
			transition: all 0.4s;
			-webkit-transition: all 0.4s;
			-o-transition: all 0.4s;
			-moz-transition: all 0.4s;
		}
		.btn-back-to-top:hover {
			opacity: 1;
			background-color: <?php echo $layout['cor']; ?>;
		}
		.icon-header-noti::after {
			content: attr(data-notify);
			font-family: Poppins-Regular;
			font-size: 12px;
			color: #fff;
			line-height: 15px;
			text-align: center;

			display: block;
			position: absolute;
			top: -7px;
			right: 0;
			min-width: 15px;
			height: 15px;
			padding: 0 3px;
			background-color: <?php echo $layout['cor']; ?>;
		}
		.main-menu-m {
			padding-top: 10px;
			padding-bottom: 10px;
			background-color: <?php echo $layout['cor']; ?>;
		}
		.swal-button {
			background-color: <?php echo $layout['cor']; ?>;
			font-family: Poppins-Regular;
			font-size: 16px;
			color: white;
			text-transform: uppercase;
			font-weight: unset;
			border-radius: 4px;
			-webkit-transition: all 0.3s;
			-o-transition: all 0.3s;
			-moz-transition: all 0.3s;
			transition: all 0.3s;
		}
		.show-search:hover:after,
		.show-filter:hover:after {
			background-color: <?php echo $layout['cor']; ?>;
			border-color: <?php echo $layout['cor']; ?>;
		}
		.cl1 {color: <?php echo $layout['cor']; ?>;}
		.bg1 {background-color: <?php echo $layout['cor']; ?>;}
		.hov-btn2:hover {
			border-color: #fff;
			background-color: #fff;
			color: <?php echo $layout['cor']; ?>;
		}
		.hov-btn3:hover {
			border-color: <?php echo $layout['cor']; ?>;
			background-color: <?php echo $layout['cor']; ?>;
			color: #fff;
		}
		.hov-tag1:hover {
			color: <?php echo $layout['cor']; ?>;
			border-color: <?php echo $layout['cor']; ?>;
		}
		.main-menu > li.active-menu > a {
			color: <?php echo $layout['cor']; ?>;
		}
		.rs1-select2 .select2-container--default .select2-selection--single .select2-selection__arrow:hover:after {
			color: <?php echo $layout['cor']; ?>;
		}
		.arrow-slick1:hover {
			color: <?php echo $layout['cor']; ?>;
		}
		.rs2-slick1 .arrow-slick1:hover {
			color: <?php echo $layout['cor']; ?>;
		}
		.filter-link:hover {
			color: <?php echo $layout['cor']; ?>;
			border-bottom: 1px solid <?php echo $layout['cor']; ?>;
		}

		.filter-link-active {
			color: <?php echo $layout['cor']; ?>;
			border-bottom: 1px solid <?php echo $layout['cor']; ?>;
		}
		.block1-txt:hover {
			background-color: <?php echo $layout['cor']; ?>;
		}
		.main-menu > li:hover > a {
			text-decoration: none;
			color: <?php echo $layout['cor']; ?>;
		}
	</style>
</head>
<body class="animsition">
	
	<!-- Header -->
	<header class="header-v2">
		<!-- Header desktop -->
		<div class="container-menu-desktop trans-03">
			<div class="wrap-menu-desktop">
				<nav class="limiter-menu-desktop p-l-45">
					
					<!-- Logo desktop -->		
					<a href="/" class="logo">
						<?php if(isset($_SESSION['logo'])): ?>
							<img src="<?php echo BASE_ASS_C; ?>images_commerce/<?php echo $_SESSION['logo']; ?>" alt="IMG-LOGO">
						<?php endif; ?>
					</a>

					<!-- Menu desktop -->
					<div class="menu-desktop">
						<ul class="main-menu">
							<li class="active-menu">
								<a href="/">Home</a>
							</li>

							<li>
								<a href="/produtos">Produtos</a>
							</li>

							<li>
								<a href="#">Categorias</a>
								<ul class="sub-menu">
									<?php foreach($cats as $dado): ?>                               
										<?php echo '<li><a href="/produtos/categoria/'.$dado['categoria_id'].'">'.$dado['nome_cat'].'</a></li>'; ?>
										<?php 
										if(count($dado['subs'])>0){
											$render("commerce/lay02/subcategoria_footer", array(
												'subs' => $dado['subs'],
												'level' => 1
											));
										}
										?>
									<?php endforeach; ?>
								</ul>
							</li>

							<!-- <li class="label1" data-label1="hot">
								<a href="#">Features</a>
							</li> -->

							<li>
								<a href="/cadastrar">Cadastre-se</a>
							</li>

							<li>
								<a href="">Sobre</a>
							</li>

							<li>
								<a href="">Contato</a>
							</li>
						</ul>
					</div>	

					<!-- Icon header -->
					<div class="wrap-icon-header flex-w flex-r-m h-full">
						<div class="flex-c-m h-full p-r-24">
							<div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 js-show-modal-search">
								<i class="zmdi zmdi-search"></i>
							</div>
						</div>
							
						<div class="flex-c-m h-full p-l-18 p-r-25 bor5">
							<div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 icon-header-noti js-show-cart" data-notify="<?php echo(isset($_SESSION['carrinho']))?count($_SESSION['carrinho']):'0'; ?>">
								<i class="zmdi zmdi-shopping-cart"></i>
							</div>
						</div>
							
						<div class="flex-c-m h-full p-lr-19">
							<div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 js-show-sidebar">
								<i class="zmdi zmdi-menu"></i>
							</div>
						</div>
					</div>
				</nav>
			</div>	
		</div>

		<!-- Header Mobile -->
		<div class="wrap-header-mobile">
			<!-- Logo moblie -->		
			<div class="logo-mobile">
				<?php if(isset($_SESSION['logo'])): ?>
					<a href="/"><img src="<?php echo BASE_ASS_C; ?>images_commerce/<?php echo $_SESSION['logo']; ?>" alt="IMG-LOGO"></a>
				<?php endif; ?>
			</div>

			<!-- Icon header -->
			<div class="wrap-icon-header flex-w flex-r-m h-full m-r-15">
				<div class="flex-c-m h-full p-r-10">
					<div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 js-show-modal-search">
						<i class="zmdi zmdi-search"></i>
					</div>
				</div>

				<div class="flex-c-m h-full p-lr-10 bor5">
					<div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 icon-header-noti js-show-cart" data-notify="<?php echo(isset($_SESSION['carrinho']))?count($_SESSION['carrinho']):'0'; ?>">
						<i class="zmdi zmdi-shopping-cart"></i>
					</div>
				</div>
			</div>

			<!-- Button show menu -->
			<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</div>
		</div>


		<!-- Menu Mobile -->
		<div class="menu-mobile">
			<ul class="main-menu-m">
				<li>
					<a href="/">Home</a>
					<ul class="sub-menu-m">
					</ul>
				</li>

				<li>
					<a href="/produtos">Produtos</a>
				</li>

				<li>
					<a class="turn-arrow-main-menu-m" href="">Categorias</a>
					<ul class="sub-menu-m" style="display: none;">
						<?php foreach($cats as $dado): ?>                               
							<?php echo '<li><a href="/produtos/categoria/'.$dado['categoria_id'].'">'.$dado['nome_cat'].'</a></li>'; ?>
							<?php 
							if(count($dado['subs'])>0){
								$render("commerce/lay02/subcategoria_footer", array(
									'subs' => $dado['subs'],
									'level' => 1
								));
							}
							?>
						<?php endforeach; ?>
					</ul>
					<span class="arrow-main-menu-m">
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</span>

				</li>

				<li>
					<a href="/cadastrar">Cadastre-se</a>
				</li>

				<li>
					<a href="">Sobre</a>
				</li>

				<li>
					<a href="">Contato</a>
				</li>
				<li>
					<a href="/cliente/painel">Minha conta <?php echo(isset($_SESSION['log_admin_c']) && !empty($_SESSION['log_admin_c']))?'- '.$_SESSION['log_admin_c']['nome']:''; ?></a>
				</li>
				<li>
					<a href="/login/c">Login</a>
				</li>
			</ul>
		</div>

		<!-- Modal Search -->
		<div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
			<div class="container-search-header">
				<button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
					X
				</button>

				<form action="/pesquisa-produtos" method="POST" class="wrap-search-header flex-w p-l-15">
					<button class="flex-c-m trans-04">
						<i class="zmdi zmdi-search"></i>
					</button>
					<input class="plh3" type="text" name="busca" placeholder="Digite para pesquisar...">
				</form>
			</div>
		</div>
	</header>

	<!-- Sidebar -->
	<aside class="wrap-sidebar js-sidebar">
		<div class="s-full js-hide-sidebar"></div>

		<div class="sidebar flex-col-l p-t-22 p-b-25">
			<div class="flex-r w-full p-b-30 p-r-27">
				<div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-sidebar">
					<i class="zmdi zmdi-close"></i>
				</div>
			</div>

			<div class="sidebar-content flex-w w-full p-lr-65 js-pscroll">
				<ul class="sidebar-link w-full">
					<!-- <li class="p-b-13">
						<a href="#" class="stext-102 cl2 hov-cl1 trans-04">
							Usuario
						</a>
					</li>

					<hr> -->
					<li class="p-b-13">
						<a href="/cliente/painel" class="stext-102 cl2 hov-cl1 trans-04">
							Minha conta <?php echo(isset($_SESSION['log_admin_c']) && !empty($_SESSION['log_admin_c']))?'- '.$_SESSION['log_admin_c']['nome']:''; ?>
						</a>
					</li>

					<li class="p-b-13">
						<a href="/" class="stext-102 cl2 hov-cl1 trans-04">
							Home
						</a>
					</li>

					<!-- <li class="p-b-13">
						<a href="#" class="stext-102 cl2 hov-cl1 trans-04">
							My Wishlist
						</a>
					</li> -->

					<li class="p-b-13">
						<a href="/carrinho" class="stext-102 cl2 hov-cl1 trans-04">
							Carrinho
						</a>
					</li>

					<li class="p-b-13">
						<a href="/login/c" class="stext-102 cl2 hov-cl1 trans-04">
							Login
						</a>
					</li>

					<!-- <li class="p-b-13">
						<a href="#" class="stext-102 cl2 hov-cl1 trans-04">
							Help & FAQs
						</a>
					</li> -->
				</ul>

				<div class="sidebar-gallery w-full p-tb-30">
					<span class="mtext-101 cl5">
						<?php echo $title; ?>
					</span>
				</div>
			</div>
		</div>
	</aside>


	<!-- Cart -->
	<div class="wrap-header-cart js-panel-cart">
		<div class="s-full js-hide-cart"></div>

		<div class="header-cart flex-col-l p-l-65 p-r-25">
			<div class="header-cart-title flex-w flex-sb-m p-b-8">
				<span class="mtext-103 cl2">
					Carrinho
				</span>

				<div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
					<i class="zmdi zmdi-close"></i>
				</div>
			</div>
			
			<div class="header-cart-content flex-w js-pscroll">
				<ul class="header-cart-wrapitem w-full">

					<?php if(!$carrinho): ?>	
						<p>Não há produtos em seu carrinho.</p>
					<?php else: ?>
						<?php foreach($carrinho as $c): ?>
							<li class="header-cart-item flex-w flex-t m-b-12">
								<div class="header-cart-item-img">
									<?php if ($c['url'] == null) : ?>
										<img src="/assets/commerce/images/semfoto.jpg" alt="Sem Imagem Produto">
                                     <?php else : ?>
										<img src="/assets/commerce/images_commerce/<?php echo $c['url']; ?>" alt="Imagem Produto">
                                     <?php endif; ?>
								</div>

								<div class="header-cart-item-txt p-t-8">
									<a href="/visualizar/produto/<?php echo $c[0]; ?>" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
										<?php echo $c['nome_pro']; ?>
									</a>

									<span class="header-cart-item-info">
										<?php echo 'R$ ' . number_format($c['preco'], 2, ',', '.'); ?>
									</span>
									<br>
									<span class="header-cart-item-info">
										<?php echo '<b>Qtd:</b> ' . $_SESSION['carrinho'][$c[0]]; ?>
									</span>
								</div>
							</li> <hr>
						<?php endforeach; ?>
					<?php endif; ?>

				</ul>
				
				<div class="w-full">
					<div id="subtotHead" class="header-cart-total w-full p-tb-40">
					<?php echo 'R$ '. $valores['total'];  ?>
					</div>

					<div class="header-cart-buttons flex-w w-full">
						<a href="/carrinho" class="flex-c-m stext-101 cl0 size-107 bgbutton bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
							Ir para carrinho
						</a>

					</div>
				</div>
			</div>
		</div>
	</div>

	<?php //echo '<pre>';print_r($carrinho); ?>
