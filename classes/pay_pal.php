<?php 
    class pay_pal extends notification implements pagto_interface {
        public function pagar($valor): void {
            echo "Pagamento no valor de {$valor} realizado via Pay Pal. ";
        }
    }
?>