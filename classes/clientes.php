<?php 
    class clientes {
        private int $id;
        private string $nome;
        private string $cpf;

        public function __construct(int $id = 0, string $nome = '', string $cpf = '')
        {
            $this->id = $id;
            $this->nome = $nome;
            $this->cpf = $cpf;
        }

        public function getId(): int {
            return $this->id;
        }
        
        public function getNome(): string {
            return $this->nome;
        }
        
        public function getCpf(): string {
            return $this->cpf;
        }

        public function gerarClientes(): array {
            return $clientes = [
                new clientes(id: 001, nome: "Isaias Lourenço", cpf: '247.074.358-31'),
                new clientes(id: 002, nome: "Éviliny Mariana", cpf: '000.000.000-00'),
                new clientes(id: 003, nome: "Afonso Lourenço", cpf: '714.463.628-68'),
            ];
        }
    }
?>