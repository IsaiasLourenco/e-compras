<?php
class produto
{
    private int $id;
    private string $descricao;
    private float $preco;
    private string $imagem;

    public function __construct(int $id = 0, string $descricao = '', float $preco = 0.00, string $imagem = '')
    {
        $this->id = $id;
        $this->descricao = $descricao;
        $this->preco = $preco;
        $this->imagem = $imagem;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function getPreco(): float
    {
        return $this->preco;
    }

    public function getImagem(): string
    {
        return $this->imagem;
    }

    public function gerarProduto(): array
    {
        return $produtos = [
            new produto(id: 001, descricao: "Notebook", preco: 1250.99, imagem: "notebook.png"),
            new produto(id: 002, descricao: "Teclado", preco: 120.00, imagem: "teclado.jpg"),
            new produto(id: 003, descricao: "Tablet", preco: 1000.00, imagem: "tablet.jpg"),
            new produto(id: 004, descricao: "Óculos", preco: 2690.00, imagem: "oculos.png"),
            new produto(id: 005, descricao: "Iphone", preco: 8500.00, imagem: "iphone.jpg"),
            new produto(id: 006, descricao: "Phone", preco: 2100.00, imagem: "fone.png"),
        ];
    }

    public function obterProdutos(): array
    {
        return $this->gerarProduto();
    }

    public function obterProdutoPorId($id): produto|null
    {
        $produtos = $this->gerarProduto();
        foreach ($produtos as $prod):
            if ($prod->getId() == $id):
                return $prod;
            endif;
        endforeach;
        return null;
    }
    public function getPrecoFormatado(): string
    {
        return 'R$ ' . number_format($this->preco, 2, ',', '.');
    }
}
