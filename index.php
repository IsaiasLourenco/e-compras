<?php
// Se "arquivo" estiver definido e conter um '=' interno, isto significa que a query string chegou errada.
// Exemplo da query errada: "arquivo=controladorinserir_carrinho=inserir_carrinho"
if (isset($_GET['arquivo']) && strpos($_GET['arquivo'], '=') !== false) {
    // Divide a string limitando o explode a 2 partes
    list($temp, $met) = explode('=', $_GET['arquivo'], 2);
    // Se a parte inicial começar com "controlador", assumimos que o nome correto é "controlador"
    // e o método desejado é o que estava depois do '='.
    if (stripos($temp, 'controlador') === 0) {
        $_GET['arquivo'] = 'controlador';
        // Se 'metodo' ainda não foi setado, a definimos pelo valor extraído.
        if (!isset($_GET['metodo'])) {
            $_GET['metodo'] = $met;
        }
    }
}

// Define valores padrão se ainda não existirem
$controller = isset($_GET['arquivo']) ? $_GET['arquivo'] : 'controlador';
$method     = isset($_GET['metodo'])  ? $_GET['metodo']  : 'index';

$controllerFile = "classes/" . $controller . ".php";
if (!file_exists($controllerFile)) {
    die("Arquivo {$controllerFile} não existe. Verifique a URL ou o nome do controlador.");
}

require_once $controllerFile;
$obj = new $controller();

if (!method_exists($obj, $method)) {
    die("O método {$method} não existe na classe {$controller}.");
}

$obj->$method();
?>