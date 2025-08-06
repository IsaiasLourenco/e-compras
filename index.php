<?php

include "vendor/autoload.php";

// Correção antecipada de nomes
if (isset($_GET['arquivo'])) {
    $correcoes = [
        "Pay-Pal" => "PayPal",
        "PayPal" => "PayPal",
        "Cartão de Crédito" => "cartao_credito",
        "Cartao de Credito" => "cartao_credito",
        "controlador" => "Controlador",
        "CONTROLADOR" => "Controlador"
    ];

    $arquivo = $_GET['arquivo'];

    if (array_key_exists($arquivo, $correcoes)) {
        $_GET['arquivo'] = $correcoes[$arquivo];
    }

    // Se a query estiver quebrada tipo: "arquivo=controladorinserir_carrinho=inserir_carrinho"
    if (strpos($_GET['arquivo'], '=') !== false) {
        list($temp, $met) = explode('=', $_GET['arquivo'], 2);
        if (stripos($temp, 'controlador') === 0) {
            $_GET['arquivo'] = 'Controlador';
            $_GET['metodo'] = $_GET['metodo'] ?? $met;
            $_GET['parametro'] = $_GET['parametro'] ?? null;
        }
    }
}

use App\Controlador;

$controller = $_GET['arquivo'] ?? 'Controlador';
$method     = $_GET['metodo'] ?? 'index';
$parametro  = $_GET['parametro'] ?? null;

$classes = "App\\" . $controller;
$obj = new $classes;

if (!method_exists($obj, $method)) {
    die("O método {$method} não existe na classe {$controller}.");
}

if (!empty($parametro)) {
    $obj->$method($parametro);
} else {
    $obj->$method();
}