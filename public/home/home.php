<?php
require_once "../shared/header.php"

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/site.css">
</head>

<body>

    <section class="banner mg-t-2">
        <div class="container">
            <div class="box-8 flex justify-center item-centro">
                <div class="box-6 mg-t-2">
                    <span class="bg-p1-laranja fonte16 pd-l-1 block wd-50">Grandes promoções</span>
                    <h3 class="fonte50">
                        Venha conferir! <br>
                        Nossos preços <br> estão incríveis!
                    </h3>
                </div>
            </div>
        </div>
    </section>

    <section class="prod mg-t-2">
        <div class="container bg-branco radius">
            <div class="box-12 mg-b-2">
                <h3 class="fonte40 fnc-preto-1 poppins-black">Produtos em Destaque</h3>
            </div>
            <div class="box-2 borda-1 shadow-down pd-10">
                <div class="box-12">
                    <h4 class="fonte14 txt-c mg-b-2">Promoção</h4>
                </div>
                <div class="box-8">
                    <img src="../../assets/img/notebook.png" alt="Notebook" title="Notebook">
                </div>
                <div class="box-12">
                    <p class="fonte14">Notebook</p>
                    <div class="divider"></div>
                </div>
                <div class="box-12">
                    <p class="fonte18 poppins-black txt-c mg-t-2">R$ 1.250,99</p>
                    <a href="" class="btn-100 bg-p7-electric mg-t-2 fnc-branco fonte14 bg-p2-verde-hover">inserir no carrinho</a>
                </div>
            </div>
        </div>
    </section>

    <?php 
        require_once "../shared/footer.php";
    ?>

</body>

</html>