<?php
namespace App;
class Produto
{
    private $id;
    private $descricao;
    private $preco;
    private $imagem;

    public function __construct($id = 0, $descricao = '', $preco = 0.00, $imagem = '')
    {
        $this->id = $id;
        $this->descricao = $descricao;
        $this->preco = $preco;
        $this->imagem = $imagem;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function getPreco()
    {
        return $this->preco;
    }

    public function getImagem()
    {
        return $this->imagem;
    }

    public function gerarProduto()
    {
        return $produtos = [
            new Produto(1, "Notebook", 1250.99, "notebook.png"),
            new Produto(2, "Teclado", 120.00, "teclado.jpg"),
            new Produto(3, "Tablet", 1000.00, "tablet.jpg"),
            new Produto(4, "Óculos", 2690.00, "oculos.png"),
            new Produto(5, "Iphone", 8500.00, "iphone.jpg"),
            new Produto(6, "Phone", 2100.00, "fone.png"),
        ];
    }

    public function obterProdutos()
    {
        return $this->gerarProduto();
    }

    public function obterProdutoPorId($id)
    {
        $produtos = $this->gerarProduto();
        foreach ($produtos as $prod):
            if ($prod->getId() == $id):
                return $prod;
            endif;
        endforeach;
        return null;
    }
    public function getPrecoFormatado()
    {
        return 'R$ ' . number_format($this->preco, 2, ',', '.');
    }
}
