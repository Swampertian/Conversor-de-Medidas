<?php

class CalculadoraNum {
    private $numero1;
    private $numero2;

    public function setNumeros($a, $b) {
        $this->numero1 = $a;
        $this->numero2 = $b;
    }

    public function somar() {
        return $this->numero1 + $this->numero2;
    }

    public function subtrair() {
        return $this->numero1 - $this->numero2;
    }

    public function multiplicar() {
        return $this->numero1 * $this->numero2;
    }

    public function dividir() {
        if ($this->numero2 == 0) {
            return 'Erro: Divisão por zero';
        }
        return $this->numero1 / $this->numero2;
    }
    public function raizQuadrada() {
        if ($this->numero1 < 0) {
            return 'Erro: Número negativo';
        }
        return sqrt($this->numero1);
    }
    public function logaritmo() {
        if ($this->numero1 <= 0 || $this->numero2 <= 0) {
            return 'Erro: Base e logaritmando devem ser maiores que zero';
        }
        return log($this->numero2) / log($this->numero1); // Calcula o logaritmo do número 2 na base do número 1
    }

}

?>

