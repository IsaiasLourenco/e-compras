<?php 
    class venda {
        private float $valor;
        private clientes $cliente;
        private DateTime $data_venda;
        public function __construct(float $valor, clientes $cliente)
        {
            $this->valor = $valor;
            $this->cliente = $cliente;
            $this->data_venda = new DateTime();
        }

        public function getValor(): float {
            return $this -> valor;
        }
        
        public function getCliente(): clientes {
            return $this -> cliente;
        }
        
        public function getDataVenda(): DateTime {
            return $this -> data_venda;
        }
    }
?>