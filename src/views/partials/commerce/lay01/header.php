<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>

    <!-- Google Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,700,600' rel='stylesheet'
        type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,100' rel='stylesheet' type='text/css'>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php echo BASE_ASS_C; ?>lay01/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/commerce/lay01/css/font-awesome.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo BASE_ASS_C; ?>lay01/css/owl.carousel.css">
    <link rel="stylesheet" href="<?php echo BASE_ASS_C; ?>lay01/css/style.css">
    <link rel="stylesheet" href="<?php echo BASE_ASS_C; ?>lay01/css/responsive.css">

    <?php if(isset($_SESSION['ico'])): ?>
        <link rel="shortcut icon" href="<?php echo BASE_ASS_C; ?>images_commerce/<?php echo $_SESSION['ico']; ?>">
    <?php endif; ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        .cart-amunt {
            color: <?php echo $layout['cor']; ?>;
            font-weight: 700;
        }
        .product-count {
            background: none repeat scroll 0 0 <?php echo $layout['cor']; ?>;
            border-radius: 50%;
            color: #fff;
            display: inline-block;
            font-size: 10px;
            height: 20px;
            padding-top: 2px;
            position: absolute;
            right: -10px;
            text-align: center;
            top: -10px;
            width: 20px;
        }
        .shopping-item:hover {
            background: none repeat scroll 0 0 <?php echo $layout['cor']; ?>;
            border-color: <?php echo $layout['cor']; ?>;
        }
        .block-slider .bx-prev:hover,
        .block-slider .bx-next:hover{
            background: <?php echo $layout['cor']; ?>;
            color: #fff;
            border-color: <?php echo $layout['cor']; ?>;
        }
        .button-radius .icon:before{
            font-family: 'FontAwesome';
            content: "\f105";
            font-size: 14px;
            color: #fff;
            width: 28px;
            height: 28px;
            background-color: <?php echo $layout['cor']; ?>;
            border-radius: 90%;
            text-align: center;
            line-height: 26px;
            float: left;
            -webkit-transition: all 1s ease-out;
            -moz-transition: all 1s ease-out;
            -o-transition: all 1s ease-out;
            -ms-transition: all 1s ease-out;
            transition: all 1s ease-out;
            }
        .product-hover a {
            background: none repeat scroll 0 0 <?php echo $layout['cor']; ?>;
            border-radius: 5px;
            color: #fff;
            display: block;
            font-size: 16px;
            left: 10%;
            margin: 0;
            padding: 10px;
            position: absolute;
            text-align: center;
            text-transform: uppercase;
            border: 1px solid #5a88ca;
            width: 80%;z-index: 99;transition: .4s;
        }
        .product-carousel-price ins {
            color: <?php echo $layout['cor']; ?>;
            font-weight: 700;
            margin-right: 5px;
            text-decoration: none;
        }
        .product-wid-price ins {
            color: <?php echo $layout['cor']; ?>;
            font-weight: 700;
            margin-right: 10px;
            text-decoration: none;
        }
        .footer-about-us span {
            color: <?php echo $layout['cor']; ?>;
        }
        .footer-social a {
            background: none repeat scroll 0 0 <?php echo $layout['cor']; ?>;
            color: #fff;
            display: inline-block;
            font-size: 20px;
            height: 40px;
            margin-bottom: 10px;
            margin-right: 10px;
            padding-top: 5px;
            text-align: center;
            width: 40px;border: 1px solid <?php echo $layout['cor']; ?>;
            }    
        .footer-top-area {
            background: none repeat scroll 0 0 <?php echo $layout['cor_rodape']; ?>;
            color: #999;
            padding: 35px 0 180px;
        }
        .product-big-title-area {background: url(<?php echo BASE_ASS_C; ?>images/crossword.png) repeat scroll 0 0 <?php echo $layout['cor']; ?>}
        .product-inner-price > ins {
            color: <?php echo $layout['cor']; ?>;
            font-weight: 700;
            margin-right: 10px;
            text-decoration: none;
        }
        input[type="submit"], button[type=submit] {
            background: none repeat scroll 0 0 <?php echo $layout['cor']; ?>;
            border: medium none;
            color: #fff;
            padding: 11px 20px;
            text-transform: uppercase;
        }
        .product-tab li.active {
            background: none repeat scroll 0 0 <?php echo $layout['cor']; ?>;
        }
        .mainmenu-area ul.navbar-nav li:hover a, .mainmenu-area ul.navbar-nav li.active a {background: <?php echo $layout['cor']; ?>; color:#FFF;}
    </style>

</head>

<body>

    <div class="header-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="user-menu">
                        <ul>
                            <li><a href="#"><i class="fa fa-user"></i>Minha conta</a></li>
                            <li><a href="#"><i class="fa fa-heart"></i> Favoritos</a></li>
                            <li><a href="#"><i class="fa fa-user"></i> Login</a></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div> <!-- End header area -->

    <div class="site-branding-area">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="logo">
                        <?php if(isset($_SESSION['logo'])): ?>
                            <h1><a href="/"><img id="imagem" src="<?php echo BASE_ASS_C; ?>images_commerce/<?php echo $_SESSION['logo']; ?>"></a></h1>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <form>
                        <input style="margin-top: 40px; padding: 22px;" class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Digite para pesquisar...">
                        <datalist id="datalistOptions">
                            <option value="San Francisco">
                            <option value="New York">
                            <option value="Seattle">
                            <option value="Los Angeles">
                            <option value="Chicago">
                        </datalist>
                    </form>
                </div>
                <div class="col-sm-4">
                    <div class="shopping-item">
                        <a href="cart.html">Carrinho - <span class="cart-amunt">R$100</span> <i class="fa fa-shopping-cart"></i> <span class="product-count"><?php echo(isset($_SESSION['carrinho']))?count($_SESSION['carrinho']):'0'; ?></span></a>
                    </div>
                </div>
                
            </div>
        </div>
    </div> <!-- End site branding area -->

    <div class="mainmenu-area">
        <div class="container">
            <div class="row">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="/">Home</a></li>
                        <li><a href="shop.html">Produtos</a></li>
                        <li><a href="single-product.html">Single product</a></li>
                        <li><a href="cart.html">Cart</a></li>
                        <li><a href="checkout.html">Checkout</a></li>
                        <li><a href="#">Categorias</a></li>
                        <li><a href="#">Others</a></li>
                        <li><a href="#">Contato</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div> <!-- End mainmenu area -->