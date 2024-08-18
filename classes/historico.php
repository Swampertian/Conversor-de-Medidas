<?php

class Historico
{
    public function getHistorico() {
        return isset($_SESSION['historico']) ? $_SESSION['historico'] : [];
    }

    public function adicionarHistorico($item) {
        $_SESSION['historico'][] = $item;
    }

    public function removerItem($index) {
        if (isset($_SESSION['historico'][$index])) {
            unset($_SESSION['historico'][$index]);
            $_SESSION['historico'] = array_values($_SESSION['historico']);
        }
    }

    public function limparHistorico() {
        unset($_SESSION['historico']);
    }
}
?>
