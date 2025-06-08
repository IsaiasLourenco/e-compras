<?php 
    class controlador {
        public function index(): void {
            require_once "public/home/home.php";
        }
        public function inserir_carrinho(): void {
            require_once "public/carrinho/index.php";
        }
    }
?>