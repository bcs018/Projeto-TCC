<?php //unset($_SESSION['log_admin_c']); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $title; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php //echo BASE_ASS; ?>../../../../assets/sitePrincipal/adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo BASE_ASS; ?>adminlte/dist/css/adminlte.min.css">
  <!-- Ion Icons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- daterangepicker -->
  <link rel="stylesheet" href="<?php echo BASE_ASS; ?>adminlte/plugins/daterangepicker/daterangepicker.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?php echo BASE_ASS; ?>adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo BASE_ASS; ?>adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?php echo BASE_ASS; ?>adminlte/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo BASE_ASS; ?>adminlte/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo BASE_ASS; ?>adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo BASE_ASS; ?>adminlte/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo BASE_ASS; ?>adminlte/plugins/summernote/summernote-bs4.min.css">
	<link rel="stylesheet" href="<?php echo BASE_ASS; ?>css/toastr.min.css">
  <!-- Jquery -->
  <script src="<?php echo BASE_ASS; ?>adminlte/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery Mask -->
  <script src="<?php echo BASE_ASS; ?>js/jquery.mask.min.js"></script>


  <!-- <link rel="shortcut icon" href="<?php echo BASE_ASS; ?>/images/ico.ico"> -->

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="<?php echo BASE_ASS; ?>adminlte/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="<?php echo BASE_ASS; ?>adminlte/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a href="/admin/sair" class="nav-link" style="color:red;">
          Sair
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="../../../../assets/commerce/images/cart.png" alt="BW Logo" class="brand-image">
      <span class="brand-text font-weight-light"><?php echo $_SESSION['log_admin_c']['fantasia']; ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <?php //if($_SESSION['log_admin']['url_foto'] != null): ?>
            <!-- <img src="<?php //echo BASE_ASS.'images/user_photo/'.$_SESSION['log_admin']['url_foto']; ?>" class="img-circle elevation-2" alt="User Image"> -->
          <?php //else: ?>
            <img src="<?php echo BASE_ASS; ?>images/user_photo/user_default.png" class="img-circle elevation-2" alt="User Image">
          <?php //endif;  ?>
        </div>
        <div class="info">
          <a href="" class="d-block"><?php echo $_SESSION['log_admin_c']['nome']; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
          
          <!-- Menu Ecommerce -->
          <li class="nav-item menu-is-opening menu-open">
            <a href="#" class="nav-link active">
            <i class="nav-icon fas fas fa-bars"></i>
              <p>
                Menu
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
            <li class="nav-item">
                <a href="/admin/painel/categorias" class="nav-link">
                <i class="fas fa-plus nav-icon"></i>
                  <p>Cadastrar categoria</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/painel/marcas" class="nav-link">
                <i class="fas fa-plus nav-icon"></i>
                  <p>Cadastrar marca</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/painel/produtos" class="nav-link">
                <i class="fas fa-cart-plus nav-icon"></i>
                  <p>Cadastrar produto</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../UI/icons.html" class="nav-link">
                <i class="fas fa-cog nav-icon"></i>
                  <p>Criar categorias</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../UI/icons.html" class="nav-link">
                <i class="fas fa-search-dollar nav-icon"></i>
                  <p>Relatório de Vendas</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Dados pessoais -->

          <li class="nav-item menu-is-opening menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fas fa-user"></i>
              <p>
                Dados pessoais (Admin)
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="/painel/alterar-dados-pessoais" class="nav-link">
                <i class="fas fa-file-signature nav-icon"></i>
                  <p>Alterar dados pessoais</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../UI/icons.html" class="nav-link">
                <i class="fas fa-plus nav-icon"></i>
                  <p>Adicionar novo usuário</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>

     
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>



