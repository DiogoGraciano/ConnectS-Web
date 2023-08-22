<?php

class quadrado{
    private int $x;
    private int $y;

    public function __construct($x,$y){
        $this -> x = $x;
        $this -> y = $x;
    }
    public function getarea(){
        return ($this -> x * 2) + ($this -> y * 2);
    }  
}
class circulo{
    private int $r;
    public function __construct($r){
        $this -> r = $r;
    }
    public function getarea(){
        return pi()*($this -> r * $this -> r);
    }  
}
$quadrado = new quadrado(5,5);
$circulo = new circulo(5);
$array = [$quadrado,$circulo];

foreach ($array as $arrays){
    echo "Area: ".$arrays->getarea()."<br>";
}
?>