<?php
// Se "arquivo" estiver definido e conter um '=' interno, isto significa que a query string chegou errada.
// Exemplo da query errada: "arquivo=controladorinserir_carrinho=inserir_carrinho"
if (isset($_GET['arquivo']) && strpos($_GET['arquivo'], '=') !== false) {
    list($temp, $met) = explode('=', $_GET['arquivo'], 2);
    if (stripos($temp, 'controlador') === 0) {
        $_GET['arquivo'] = 'controlador';
        if (!isset($_GET['metodo'])) {
            $_GET['metodo'] = $met;
        }
        if (!isset($_GET['parametro'])) {
            $_GET['parametro'] = null;
        }
    }
}

// Correção do nome do controlador para evitar erro de arquivo inexistente
if (isset($_GET['arquivo'])) {
    $correcoes = [
        "Pay-Pal" => "pay_pal",
        "PayPal" => "pay_pal",
        "Cartão de Crédito" => "cartao_credito",
        "Cartao de Credito" => "cartao_credito"
    ];

    if (array_key_exists($_GET['arquivo'], $correcoes)) {
        $_GET['arquivo'] = $correcoes[$_GET['arquivo']];
    }
}

// Define valores padrão se ainda não existirem
$controller = isset($_GET['arquivo']) ? $_GET['arquivo'] : 'controlador';
$method     = isset($_GET['metodo'])  ? $_GET['metodo']  : 'index';
$parametro  = isset($_GET['parametro']) ? $_GET['parametro'] : null;

$controllerFile = "classes/" . $controller . ".php";
if (!file_exists($controllerFile)) {
    die("Arquivo {$controllerFile} não existe. Verifique a URL ou o nome do controlador.");
}

require_once $controllerFile;
$obj = new $controller();

if (!method_exists($obj, $method)) {
    die("O método {$method} não existe na classe {$controller}.");
}

// Ajuste para garantir que o método seja chamado corretamente com ou sem `$parametro`
if (!empty($parametro)) {
    $obj->$method($parametro);
} else {
    $obj->$method();
}
?>