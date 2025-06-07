<?php require_once "public/shared/header.php"; ?>

<section class="car">
    <div class="container">
        <div class="box-6 mg-t-6">
            <form action="index.php?arquivo=Controlador&metodo=finalizarCarrinho" method="POST">
                <table class="car-table">
                    <thead>
                        <tr>
                            <th class="pd-10 bg-p2-azul fonte12 fnc-branco">Código</th>
                            <th class="pd-10 bg-p2-azul fonte12 fnc-branco">Produto</th>
                            <th class="pd-10 bg-p2-azul fonte12 fnc-branco">Qtde</th>
                            <th class="pd-10 bg-p2-azul fonte12 fnc-branco">Preço</th>
                            <th class="pd-10 bg-p2-azul fonte12 fnc-branco">Imagem</th>
                            <th class="pd-10 bg-p2-azul fonte12 fnc-branco">Sub-Total</th>
                            <th class="pd-10 bg-p2-azul fonte12 fnc-branco">Ação</th>
                        </tr>
                    </thead>
                    <!-- table data -->
                    <tbody>
                        <?php 
                        if(isset($_SESSION['carrinho'])):
                            foreach($_SESSION['carrinho'] as $key => $value):     
                              echo  $subTotal = $_SESSION['carrinho'][$key]['preco'] * $_SESSION['carrinho'][$key]['qtde'];                         

                        ?>
                        <tr class="zebra">
                           
                            <td class="fonte12 pd-5 txt-c"> <?= $_SESSION['carrinho'][$key]['id']; ?></td>
                            <td class="fonte12 pd-5 txt-c"> <?= $_SESSION['carrinho'][$key]['descricao'];?></td>
                            <td class="fonte12 pd-5 txt-c"> 
                                <input type="text" class="qtde"  rel="<?= $key; ?>" value="<?= $_SESSION['carrinho'][$key]['qtde'];?> ">
                                   
                            </td>
                            <td class="fonte12 pd-5 txt-c"> <?= 'R$ '.number_format($_SESSION['carrinho'][$key]['preco'],2,',','.');?></td>
                            <td class="fonte12 pd-5 txt-c">
                                <img src="lib/img/<?= $_SESSION['carrinho'][$key]['imagem'];?>" alt="" class="logo-60 mg-auto">
                            </td>
                            <td class="fonte12 pd-5 txt-c"> R$ <?= number_format($subTotal,2,',','.'); ?></td>
                            <td>
                                <a href="index.php?arquivo=Controlador&metodo=atualizarCarrinho&linha=<?= $key; ?>" class="txt-c flex justify-center item-centro">
                                    <i class="fa-solid fa-trash-can fonte22 fnc-error"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <tr>                          
                            <td colspan="6">
                               
                                <label for="">Selecionar Clientes</label>
                                <select name="cliente" id="" class="mg-b-2">
                                    
                                    <option value="">Selecione um cliente</option>
                                    <?php 
                                    if(isset($cliente) && count($cliente) > 0 ): 
                                        foreach($cliente as $valor):  ?>
                                     <option value="<?= $valor->getId();?>"><?= $valor->getNome();?></option> 
                                       <?php endforeach; 
                                       endif;?>
                                </select>

                                <label for="">Forma de pagamento</label>
                                <select name="formapagamento" id="">
                                    <option value="">Selecionar pagamento</option>
                                    <option value="1">Boleto</option>
                                    <option value="2">Pay Pal</option>
                                    <option value="3">Cartão credito</option>
                                </select>
                            </td>
                        </tr>
                        <tr>                       
                            <td colspan="7">
                                <a href="index.php?arquivo=Controlador&metodo=index" class="btn-100  bg-p1-amarelo mg-b-1 fnc-branco fonte14 fw-800">Comprar Mais</a>
                                <input type="submit" value="Finalizar" class="btn-100 bg-p1-amarelo fnc-branco">
                            </td>
                        </tr> 
                        <?php 
                        else:?>
                        <tr>
                            <td colspan="7" >Carrinho vazio!</td>
                        </tr> 
                        
                        <?php endif;?>
                     </tbody>  
                      </table>
            </form>
        </div>
    </div>
</section>

<script type="text/javascript" src="lib/js/jquery-3.6.4.min.js"></script>
<script>

     $(function() {
        $('.qtde').change(function() {
            var linha = $(this).attr('rel');
            var quantidade = $(this).val();
            
            $.ajax({
                type: "POST",
                url: "index.php?arquivo=Controlador&metodo=atualizarCarrinho",

                data: "quantidade=" + quantidade + "&linha=" + linha,
                success: function() {
                    location.reload();
                }

            });
        });
    });

</script>
<?php require_once "public/shared/footer.php"; ?>