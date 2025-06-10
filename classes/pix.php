<?php 
    class pix extends notification implements pagto_interface {
        public function pagar($valor): void {
            echo "O Boleto no valor de {$valor} foi gerado com sucesso e aguarda o pagamento via PIX. ";
        }
    }
?>