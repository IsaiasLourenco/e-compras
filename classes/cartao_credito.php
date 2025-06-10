<?php 
    class cartao_credito extends notification implements pagto_interface {
        public function pagar($valor): void {
            echo "Pagamento no valor de {$valor} lançado na fatura do seu Cartão de Crédito. ";
        }
    }
?>