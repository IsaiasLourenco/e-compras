<?php
session_start();
require_once "classes/produto.php";
require_once "classes/clientes.php";
require_once "classes/notification.php";
require_once "classes/boleto.php";
require_once "classes/cartao_credito.php";
require_once "classes/pay_pal.php";
require_once "classes/pix.php";

class controlador extends notification
{
    public function index(): void
    {
        $prod = new produto();
        $retrn = $prod->gerarProduto();
        require_once "public/home/home.php";
    }

    public function inserir_carrinho(): void
    {
        $cliente = (new clientes())->gerarClientes();

        if ($_GET && isset($_GET['id'])) {
            $id = $_GET['id'];

            // Garante que $_SESSION['carrinho'] seja inicializado como array
            if (!isset($_SESSION['carrinho']) || !is_array($_SESSION['carrinho'])) {
                $_SESSION['carrinho'] = [];
            }

            // Verifica se o produto já existe no carrinho
            $existe = false;
            foreach ($_SESSION['carrinho'] as $linha => $valor) {
                if (isset($valor['id']) && $valor['id'] == $id) {
                    // Produto já existe, então incrementa a quantidade
                    $_SESSION['carrinho'][$linha]['qtde']++;
                    $existe = true;
                    break; // Sai do loop
                }
            }

            // Se o produto não existir no carrinho, adiciona-o
            if (!$existe) {
                $linha = count($_SESSION['carrinho']);
                $produto = (new produto())->obterProdutoPorId(id: $id);

                $_SESSION['carrinho'][$linha] = [
                    'id'        => str_pad($produto->getId(), 3, '0', STR_PAD_LEFT),
                    'descricao' => $produto->getDescricao(),
                    'preco'     => $produto->getPreco(),
                    'imagem'    => $produto->getImagem(),
                    'qtde'      => 1
                ];
            }
        }

        // Sempre recalcula o total de itens no carrinho,
        // inclusive se nenhum produto foi adicionado nesta requisição,
        // garantindo que removições sejam refletidas
        $total = 0;
        if (isset($_SESSION['carrinho']) && is_array($_SESSION['carrinho'])) {
            foreach ($_SESSION['carrinho'] as $item) {
                $total += $item['qtde'];
            }
        }
        $_SESSION['qtdeProduto'] = $total;

        require_once "public/carrinho/index.php";
    }

    public function atualizar_carrinho(): void
    {
        // Se for requisição GET e tiver o índice 'linha', trata a remoção do item
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['linha'])) {
            $linha = $_GET['linha'];
            if (isset($_SESSION['carrinho'][$linha])) {
                unset($_SESSION['carrinho'][$linha]);
                // Reindexa o array, se necessário, para manter as chaves em ordem
                $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);
            }
            header('Location: index.php?arquivo=controlador&metodo=inserir_carrinho');
            exit;
        }

        // Se for requisição POST e os dados necessitam atualização
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['linha'], $_POST['quantidade'])) {
            $linha = $_POST['linha'];
            $qtde = $_POST['quantidade'];
            if ($qtde > 0) {
                $_SESSION['carrinho'][$linha]['qtde'] = $qtde;
            }
        }

        // Recalcula o total de produtos (balão)
        $total = 0;
        if (isset($_SESSION['carrinho']) && is_array($_SESSION['carrinho'])) {
            foreach ($_SESSION['carrinho'] as $item) {
                $total += $item['qtde'];
            }
        }
        $_SESSION['qtdeProduto'] = $total;
    }

    public function finalizar_carrinho(): void {
        require_once "public/shared/header.php";
        $clienteId =  $_POST['clientes'];
        $formaPag =  $_POST['formapagamento'];

        $cli = (new clientes())->gerarClientes();
        $cliSelecionado = null;
        foreach($cli as $valorCli):
            if($valorCli->getId() == $clienteId):
                $cliSelecionado = $valorCli;
            endif;
        endforeach;

        $formaPagamento = null;
        switch ($formaPag):
            case '1':
                $formaPagamento = new pix();
                $formaPag = "PIX";
                break;
            case '2':
                $formaPagamento = new boleto();
                $formaPag = "Boleto";
                break;
            case '3':
                $formaPagamento = new pay_pal();
                $formaPag = "Pay-Pal";
                break;
            case '4':
                $formaPagamento = new cartao_credito();
                $formaPag = "Cartão de Crédito";
                break;
        endswitch;

        echo "<div class='container flex justify-center'>";
            echo "<div class='box-6 pd-10 bg-branco radius mg-t-2'>";

                echo "<div class='box-12'>";
                
                    echo "<h3 class='txt-c'>";
                        echo "Detalhes da Compra";
                    echo "</h3>";
                
                    echo "<div class='divider'></div>";
            
                    echo "<div class='box-12 bg-p3-paper radius' style='margin-top: 20px;'>";
                        echo "<p class='txt-c fonte14 espaco-letra poppins-medium'>";
                            echo "<strong class='fonte16'>Cliente:</strong> {$cliSelecionado->getNome()}<br>";
                            echo "<strong class='fonte16 mg-b-2'>Documento:</strong> {$cliSelecionado->getCpf()}"; 
                        echo "</p>";
                    echo "</div>";                            
                    
                    echo "<div class='limpar'></div> <div class='divider'></div>";
                
                    echo "<div class='box-12 mg-t-2'>";
                        echo "<h3 class='txt-c'>";
                            echo "Itens no carrinho";
                        echo "</h3>";
                    echo "</div>";

                    echo "<div class='limpar'></div> <div class='divider'></div>";

                    if (isset($_SESSION['carrinho'])):
                        $total = 0;
                        foreach($_SESSION['carrinho'] as $key => $valor):
                            $subTotal = $valor['qtde'] * $valor['preco'];
                            $total += $subTotal;
                            echo "<div class='box-12 bg-p3-paper radius' style='margin-top: 20px;'>";
                                echo "<div class='box-2'>";
                                    echo "<img src='assets/img/{$valor['imagem']}' class='logo-40' />";
                                echo "</div>";   
                                echo "<div class='box-10'>";
                                    echo "<p class='item'>";
                                        echo "<span class='label fonte16'><strong>Descrição:</strong></span> ";
                                        echo "<span class='fonte14'>{$valor['descricao']}</span>";
                                    echo "</p>";
                                echo "<p class='item'>";
                                    echo "<span class='label fonte16'><strong>Qtde:</strong></span> ";
                                    echo "<span class='fonte14'>{$valor['qtde']}</span>";
                                echo "</p>";
                                echo "<p class='item'>";
                                    echo "<span class='label fonte16'><strong>Sub-Total:</strong></span> ";
                                    $subTotalFormatado = "R$ " . number_format($subTotal, 2, ',', '.');
                                    echo "<span class='fonte14'>{$subTotalFormatado}</span>";
                                echo "</p>";
                            echo "</div>";   
                            
                            echo "<div class='limpar'></div> <div class='divider'></div>";   

                        endforeach;
                    endif;

                    echo "<div class='box-12' style='text-align: right; margin: 20px 0;'>";
                        $totalFormatado = "R$ " . number_format($total, 2, ',', '.');
                        echo "<h3 style='font-size: 3rem;'>";
                            echo "<span style='font-weight: bold;'>Total:</span> ";
                            echo "<span style='font-weight: normal;'>$totalFormatado</span>";
                        echo "</h3>";
                    echo "</div>";

                    echo "<div class='box-12'>";
                        echo "<p class='bg-p1-verde2 radius pd-10' style='font-size: 18px; text-align: center; margin: 20px 0;'>";
                            echo "<strong class='fnc-verde'>Pagamento realizado via:</strong> {$formaPag}";
                        echo "</p>";
                    echo "</div>";

                echo "</div>";

                echo "<div class='box-12 mg-t-2'>";
                    echo "<a href='index.php?arquivo=$formaPag&metodo=pagar&parametro=$total' class='btn-100 bg-p1-laranja fonte16'>";
                        echo "Finalizar carrinho!";
                    echo "</a>";
                echo "</div>";

            echo "</div>";

        echo "</div>";

        unset($_SESSION['carrinho']);
        unset($_SESSION['qtdeProduto']);
    }
}
