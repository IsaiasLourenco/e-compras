<?php 
if (!isset($_SESSION)):
    session_start();
endif;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>e-letronicost</title>
  <link rel="stylesheet" href="assets/css/aurora.css">
  <link rel="stylesheet" href="assets/css/aurora-responsivo.css" media="(max-width: 768px)">
  <link rel="stylesheet" href="assets/css/site.css">
  <link rel="stylesheet" href="assets/css/carrinho.css">
  <link rel="shortcut icon" href="assets/img/icone.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
  <header class="header-light pd-10">
    <div class="container flex sm-stack xs-pd-10">
      <div class="box-4 sm-wd-100 xs-wd-100">
        <a href="index.php?arquivo=controlador&metodo=index">
          <h1 class="fonte42 fnc-preto-1 poppins-black xs-fonte28">e-compras</h1>
        </a>
      </div>
      <div class="box-8 sm-wd-100 xs-wd-100">
        <ul class="flex justify-end pd-t-1 sm-justify-center xs-justify-center">
          <li>
            <a href="index.php?arquivo=controlador&metodo=inserir_carrinho" class="flex justify-end item-centro mg-l-1 mg-r-1">
              <i class="fa-solid fa-cart-shopping fonte26 fnc-preto-1 xs-fonte20"></i>
              <span class="balao flex justify-center item-centro fonte14 xs-fonte12">
                <?php 
                  if (isset($_SESSION['carrinho'])):
                      echo $_SESSION['qtdeProduto'];
                  else:
                      echo '0';
                  endif; 
                ?>
              </span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </header>