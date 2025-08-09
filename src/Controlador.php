<?php

namespace App;

use Dompdf\Dompdf;
use Dompdf\Options;
use Exception;

session_start();

class Controlador extends Notification
{
    public function index(): void
    {
        $prod = new Produto();
        $retrn = $prod->gerarProduto();
        require_once "public/home/home.php";
    }

    public function inserir_carrinho(): void
    {
        $cliente = (new Clientes())->gerarClientes();

        if ($_GET && isset($_GET['id'])) {
            $id = $_GET['id'];

            if (!isset($_SESSION['carrinho']) || !is_array($_SESSION['carrinho'])) {
                $_SESSION['carrinho'] = [];
            }

            $existe = false;
            foreach ($_SESSION['carrinho'] as $linha => $valor) {
                if (isset($valor['id']) && $valor['id'] == $id) {
                    $_SESSION['carrinho'][$linha]['qtde']++;
                    $existe = true;
                    break;
                }
            }

            if (!$existe) {
                $linha = count($_SESSION['carrinho']);
                $produto = (new Produto())->obterProdutoPorId($id);

                $_SESSION['carrinho'][$linha] = [
                    'id'        => str_pad($produto->getId(), 3, '0', STR_PAD_LEFT),
                    'descricao' => $produto->getDescricao(),
                    'preco'     => $produto->getPreco(),
                    'imagem'    => $produto->getImagem(),
                    'qtde'      => 1
                ];
            }
        }

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
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['linha'])) {
            $linha = $_GET['linha'];
            if (isset($_SESSION['carrinho'][$linha])) {
                unset($_SESSION['carrinho'][$linha]);
                $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);
            }
            header('Location: index.php?arquivo=controlador&metodo=inserir_carrinho');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['linha'], $_POST['quantidade'])) {
            $linha = $_POST['linha'];
            $qtde = $_POST['quantidade'];
            if ($qtde > 0) {
                $_SESSION['carrinho'][$linha]['qtde'] = $qtde;
            }
        }

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

        if (ob_get_length()) {
            ob_end_clean();
        }

        @$clienteId = $_POST['clientes'] ?? '';
        @$formaPag = $_POST['formapagamento'] ?? '';

        if ($clienteId === '') {
            $this->error('Por favor, escolha um cliente para finalizar a compra!', 'controlador', 'inserir_carrinho');
            return;
        }

        if ($formaPag === '') {
            $this->error('Por favor, selecione uma forma de pagamento!', 'controlador', 'inserir_carrinho');
            return;
        }

        $cli = (new Clientes())->gerarClientes();
        $cliSelecionado = null;
        foreach ($cli as $valorCli) {
            if ($valorCli->getId() == $clienteId) {
                $cliSelecionado = $valorCli;
                break;
            }
        }

        switch ($formaPag) {
            case '1': $formaPag = "PIX"; break;
            case '2': $formaPag = "Boleto"; break;
            case '3': $formaPag = "PayPal"; break;
            case '4': $formaPag = "Cartão de Crédito"; break;
        }

        $_SESSION['dados_pdf'] = [
            'cliente' => $cliSelecionado,
            'forma_pagamento' => $formaPag,
            'carrinho' => $_SESSION['carrinho']
        ];

        unset($_SESSION['carrinho']);
        unset($_SESSION['qtdeProduto']);

        echo "<html><head><script>
            window.open('index.php?arquivo=controlador&metodo=gerar_pdf', '_blank');
            setTimeout(function() {
                window.location.href = 'index.php?arquivo=controlador&metodo=index';
            }, 3000);
        </script></head><body>
            <p style='text-align:center; font-size:18px;'>Finalizando compra... Gerando PDF...</p>
        </body></html>";
        exit;
    }

        public function gerar_pdf(): void
    {
        $dados = $_SESSION['dados_pdf'] ?? null;
        if (!$dados) {
            echo "Dados da compra não encontrados.";
            return;
        }

        $cliSelecionado = $dados['cliente'];
        $formaPag = $dados['forma_pagamento'];
        $carrinho = $dados['carrinho'];

        $css = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/e-compras/assets/css/aurora.css');
        $html = "<style>" . $css . "</style>";
        $html .= "<div style='width: 100%; font-family: Arial, sans-serif;'>";
        $html .= "<h2 style='text-align: center;'>Detalhes da Compra</h2><hr>";
        $html .= "<p style='text-align: center;'><strong>Cliente:</strong> {$cliSelecionado->getNome()}<br>";
        $html .= "<strong>Documento:</strong> {$cliSelecionado->getCpf()}</p><hr>";
        $html .= '<h3 style="text-align: center;">Itens no carrinho</h3>';

        $total = 0;
        foreach ($carrinho as $valor) {
            $precoUnitario = $valor['preco'];
            $qtde = $valor['qtde'];
            $subTotal = $qtde * $precoUnitario;
            $total += $subTotal;

            $precoFormatado = "R$ " . number_format($precoUnitario, 2, ',', '.');
            $subTotalFormatado = "R$ " . number_format($subTotal, 2, ',', '.');

            $html .= "<table style='width: 100%; margin-bottom: 20px; border: 1px solid #ccc; border-collapse: collapse;'>";
            $html .= "<tr>";
            $html .= "<td style='width: 80px; padding: 10px; vertical-align: top; border-right: 1px solid #ccc;'>";
            $html .= "<img src='http://localhost/e-compras/assets/img/{$valor['imagem']}' style='width: 60px; height: auto;' />";
            $html .= "</td>";
            $html .= "<td style='padding: 10px; vertical-align: top;'>";
            $html .= "<p><strong>Descrição:</strong> {$valor['descricao']}</p>";
            $html .= "<p><strong>Preço unitário:</strong> {$precoFormatado}</p>";
            $html .= "<p><strong>Qtde:</strong> {$qtde}</p>";
            $html .= "<p><strong>Sub-Total:</strong> {$subTotalFormatado}</p>";
            $html .= "</td></tr></table>";
        }

        $totalFormatado = "R$ " . number_format($total, 2, ',', '.');
        $html .= "<h3 style='text-align: right; padding-right: 80px;'>Total: {$totalFormatado}</h3>";
        $html .= "<p style='background-color: #d4edda; padding: 10px; border-radius: 5px; text-align: center; font-size: 16px;'>";
        $html .= "<strong>Pagamento realizado via:</strong> {$formaPag}</p>";
        $html .= "</div>";

        $options = new Options();
        $options->set('isHtml5ParseEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        try {
            $dompdf->render();
            $dompdf->stream('Detalhes_da_Venda.pdf', ['Attachment' => false]);
        } catch (Exception $e) {
            echo 'Erro ao gerar PDF ' . $e->getMessage();
        }

        unset($_SESSION['dados_pdf']);
        unset($_SESSION['carrinho']);
        unset($_SESSION['qtdeProduto']);
        exit;
    }
}