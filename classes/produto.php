<?php 
    class produto {
        private int $id;
        private string $descricao;
        private float $preco;
        private string $imagem;

        public function __construct(int $id, string $descricao, float $preco, string $imagem)
        {
            $this->id = $id;
            $this->descricao = $descricao;
            $this->preco = $preco;
            $this->imagem = $imagem;
        }

        public function getId(): int {
            return $this->id;
        }
        
        public function getDescricao(): string {
            return $this->descricao;
        }
        
        public function getPreco(): float {
            return $this->preco;
        }
        
        public function getImagem(): string {
            return $this->imagem;
        }


    }
?>