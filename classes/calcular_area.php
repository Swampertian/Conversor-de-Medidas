<?php
class Calculadora {

    public function CalcAreaRetangulo($numA, $numB) {
        return $numA * $numB;
    }

    public function CalcAreaTriangulo($numA, $numB) {
        return ($numA * $numB) / 2;
    }

    public function CalcAreaCirculo($raio) {
        return round(pi() * pow($raio, 2),2);
    }
}
?>
