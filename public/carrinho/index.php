<?php
require_once "public/shared/header.php";
?>
<section class="cart">
    <div class="container">
        <div class="box-6 mg-t-2">
            <form action="index.php?arquivo=controlador&metodo=finalizar_carrinho" method="POST">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th class="pd-10 bg-p2-azul fonte12 fnc-branco">Código</th>
                            <th class="pd-10 bg-p2-azul fonte12 fnc-branco">Produto</th>
                            <th class="pd-10 bg-p2-azul fonte12 fnc-branco">Quantidade</th>
                            <th class="pd-10 bg-p2-azul fonte12 fnc-branco">Preço</th>
                            <th class="pd-10 bg-p2-azul fonte12 fnc-branco">Imagem</th>
                            <th class="pd-10 bg-p2-azul fonte12 fnc-branco">Sub-Total</th>
                            <th class="pd-10 bg-p2-azul fonte12 fnc-branco">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_SESSION['carrinho']) && is_array($_SESSION['carrinho'])):
                            foreach ($_SESSION['carrinho'] as $key => $value):
                                // Verifica se o item possui os índices esperados
                                if (!isset($value['id'], $value['descricao'], $value['preco'], $value['qtde'], $value['imagem'])) {
                                    continue;
                                }
                        ?>
                                <tr class="zebra">
                                    <td class="txt-c"><?= str_pad($value['id'], 3, '0', STR_PAD_LEFT); ?></td>
                                    <td class="txt-c"><?= $value['descricao']; ?></td>
                                    <td class="txt-c">
                                        <input type="number"
                                            style="width: 80px; font-size: 12px; font-weight: bolder; text-align: center;"
                                            class="qtde"
                                            rel="<?= $key; ?>"
                                            value="<?= str_pad($value['qtde'], 3, '0', STR_PAD_LEFT); ?>">
                                    </td>
                                    <td class="txt-c"><?= 'R$ ' . number_format($value['preco'], 2, ',', '.'); ?></td>
                                    <td class="txt-c">
                                        <img src="assets/img/<?= $value['imagem']; ?>" class="logo-40 mg-auto">
                                    </td>
                                    <td class="txt-c">
                                        <?= 'R$ ' . number_format($value['preco'] * $value['qtde'], 2, ',', '.'); ?>
                                    </td>
                                    <td class="txt-c">
                                        <a href="index.php?arquivo=controlador&metodo=atualizar_carrinho&linha=<?= $key; ?>">
                                            <i class="fa-solid fa-trash-can fonte16 fnc-error"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                            endforeach;
                            ?>
                            <tr>
                                <td colspan="7">
                                    <label for="clientes">Selecione o cliente:</label>
                                    <select name="clientes" id="" class="mg-b-2">
                                        <option value="" selected disabled>Selecione um cliente</option>
                                        <?php
                                        if (isset($cliente) && count($cliente) > 0):
                                            foreach ($cliente as $valor): ?>
                                                <option value="<?= $valor->getId(); ?>"><?= $valor->getNome(); ?></option>
                                        <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>

                                    <label for="clientes">Selecione o pagamento:</label>
                                    <select name="formapagamento" id="">
                                        <option value="" selected disabled>Formas de Pagamento</option>
                                        <option value="1">PIX</option>
                                        <option value="2">Boleto</option>
                                        <option value="3">Pay Pal</option>
                                        <option value="4">Crédito</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    <a href="index.php?arquivo=controlador&metodo=index" class="btn-100 bg-p1-amarelo fonte14 fw-800 mg-b-1">Comprar Mais</a>
                                    <input type="submit" value="Finalizar" class="btn-100 bg-p1-amarelo fonte14 fw-800">
                                </td>
                            </tr>
                        <?php
                        else:
                        ?>
                            <tr>
                                <td colspan="7">Carrinho vazio!</td>
                            </tr>
                        <?php
                        endif;
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</section>
<script type="text/javascript" src="assets/js/jquery-3.6.4.min.js"></script>
<script>
    $(function() {
        $('.qtde').change(function() {
            var linha = $(this).attr('rel');
            var quantidade = $(this).val();

            $.ajax({
                type: "POST",
                url: "index.php?arquivo=controlador&metodo=atualizar_carrinho",
                data: "quantidade=" + quantidade + "&linha=" + linha,
                success: function() {
                    location.href = "index.php?arquivo=controlador&metodo=inserir_carrinho";
                }
            });
        });
    });
</script>
<?php
require_once "public/shared/footer.php";
?>