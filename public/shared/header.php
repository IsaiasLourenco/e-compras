<?php

ob_start();
if (!isset($_SESSION)):
    session_start();
endif;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-letronicos</title>
    <!-- INSERIRNDO CDN DO FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- INSERINDO CSS -->
    <link rel="stylesheet" href="../../assets/css/aurora.css">
    <link rel="stylesheet" href="../../assets/css/site.css">
</head>

<body>
    <header class="header-light pd-10">
        <div class="container">
            <div class="box-4">
                <a href="index.php?arquivo=Controlador&metodo=index">
                    <h1 class="fonte42 fnc-preto-1 poppins-black">e-Compras</h1>
                </a>
            </div>
            <div class="box-8">
                <ul class="flex justify-end pd-t-1">
                    <li>
                        <a href="index.php?arquivo=Controlador&metodo=inserirCarrinho" class="flex justify-end item-centro mg-l-1">
                            <i class="fa-solid fa-cart-shopping fonte26 fnc-preto-1"></i>
                            <span class="balao flex justify-center item-centro  fnc-branco">
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