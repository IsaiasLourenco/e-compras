<?php
session_start();
require_once "classes/produto.php";
require_once "classes/clientes.php";
require_once "classes/notification.php";

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

    public function finalizar_carrinho(): void
    {
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
        switch ($formaPagamento):
            case '1':
                $formaPagamento = new pix();
                break;
            case '2':
                $formaPagamento = new boleto();
                break;
            case '3':
                $formaPagamento = new pay_pal();
                break;
            case '4':
                $formaPagamento = new cartao_credito();
                break;
        endswitch;

        echo "<div class='container flex justify-center'>";
            echo "<div class='box-6 pd-10 bg-branco radius mg-t-2'>";

                echo "<div class='box-12'>";
                
                    echo "<h3 class='txt-c'>";
                        echo "Detalhes da Compra";
                    echo "</h3>";
                
                    echo "<div style='border-bottom: 1px solid #ccc; padding: 10px 0; margin: -10px 0;'></div>";

                    echo "<div class='box-12'>";
                        echo "<div class='box-12' style='margin-top: 20px;'>";
                            echo "<p class='txt-c fonte14 espaco-letra poppins-medium'>";
                                echo "<strong class='fonte16'>Cliente:</strong> {$cliSelecionado->getNome()}<br>";
                                echo "<strong class='fonte16'>Documento:</strong> {$cliSelecionado->getCpf()}"; 
                            echo "</p>";
                        echo "</div>";                            
                    echo "</div>";
                
                    echo "<div class='box-12 mg-t-2'>";
                        echo "<h3 class='txt-c'>";
                            echo "Itens no carrinho";
                        echo "</h3>";
                    echo "</div>";

                    echo "<div style='border-bottom: 1px solid #ccc; padding: 10px 0; margin-top: 120px; margin-bottom: 20px;'></div>";

                echo "</div>";

            echo "</div>";

        echo "</div>";
    }
}
