<?php
require_once "public/shared/header.php";
?>
<section class="cart">
    <div class="container">
        <div class="box-6 mg-t-2">
            <form action="" method="POST">
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
                        <tr class="zebra">
                            <td class="txt-c">001</td>
                            <td class="txt-c">Notebook</td>
                            <td class="txt-c">002</td>
                            <td class="txt-c">R$ 1.250,99</td>
                            <td class="txt-c">
                                <img src="assets/img/notebook.png" alt="Notebook" title="Notebook" class="logo-40 mg-auto">
                            </td>
                            <td class="txt-c">R$ 1.250,99</td>
                            <td class="txt-c">
                                <a href="">
                                    <i class="fa-solid fa-trash-can fonte16 fnc-error"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7">
                                <label for="clientes">Selecione o cliente:</label>
                                <select name="clientes" id="" class="mg-b-2">
                                    <option value="" selected disabled>Selecione um cliente</option>
                                    <option value="">Isaias Lourenço</option>
                                    <option value="">Eviliny Mariana</option>
                                </select>

                                <label for="clientes">Selecione o pagamento:</label>
                                <select name="clientes" id="">
                                    <option value="" selected disabled>Formas de Pagamento</option>
                                    <option value="">Boleto</option>
                                    <option value="">Pay Pal</option>
                                    <option value="">PIX</option>
                                    <option value="">Crédito</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7">
                                <a href="index.php?arquivo=controlador&metodo=index" class="btn-100 bg-p1-amarelo fonte14 fw-800 mg-b-1">Comprar Mais</a>
                                <input type="submit" value="Finalizar" class="btn-100 bg-p1-amarelo fonte14 fw-800">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</section>
<?php
require_once "public/shared/footer.php";
?>