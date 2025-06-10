<?php
require_once "classes/notification.php";
require_once "classes/pagto_interface.php";
class boleto extends notification implements pagto_interface
{
    public function pagar($valor): void
    {
        // Verifica se 'parametro' foi passado e converte corretamente para float
        if (isset($_GET['parametro']) && $_GET['parametro'] !== '') {
            $valor = (float) $_GET['parametro'];
        } else {
            $valor = 0; // Define um valor padrão
        }

        // Mensagem formatada corretamente
        $msg = "O Boleto no valor de " . number_format($valor, 2, ',', '.') .
            " foi gerado com sucesso e aguarda o pagamento. <br>";

        // Exibe a mensagem ao invés de retornar
        $this->success(msg: $msg, arquivo: 'controlador', metodo: 'index');
    }
}
