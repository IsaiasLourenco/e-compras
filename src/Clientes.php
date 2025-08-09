<?php 
namespace App;

class Clientes {
    private $id;
    private $nome;
    private $cpf;

    public function __construct($id = 0, $nome = '', $cpf = '')
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->cpf = $cpf;
    }

    public function getId()
    {
        return $this->id;
    }
    
    public function getNome()
    {
        return $this->nome;
    }
    
    public function getCpf()
    {
        return $this->cpf;
    }

    public function gerarClientes()
    {
        return [
            new Clientes(1, "Isaias Lourenço", '247.074.358-31'),
            new Clientes(2, "Éviliny Mariana", '000.000.000-00'),
            new Clientes(3, "Afonso Lourenço", '714.463.628-68'),
        ];
    }
}
?>