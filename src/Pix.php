<?php
namespace App;

class Pix extends Notification implements PagtoInterface {
    public function pagar($valor): void {
        // Verifica se 'parametro' foi passado e converte corretamente para float
        if (isset($_GET['parametro']) && $_GET['parametro'] !== '') {
            $valor = (float) $_GET['parametro'];
        } else {
            $valor = 0; // Define um valor padrão
        }

        // Mensagem formatada corretamente
        $msg = "O pagamento via PIX no valor de " . number_format($valor, 2, ',', '.') . 
               " foi gerado com sucesso e aguarda o pagamento. <br>";

        // Exibe a mensagem ao invés de retornar
        $this->success(msg: $msg, arquivo: 'Controlador', metodo: 'index');
    }
}
?>