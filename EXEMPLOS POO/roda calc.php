<?php
require "calc.php";

$calc = new calc();
$calc -> add(12); 
$calc -> add(2); 
$calc -> sub(1); 
$calc -> mut(3); 
$calc -> div(2); 
$calc -> add(0.5); 

echo "Total: ".$calc -> total()."<br>";
$calc -> clear();

$calc = new calc();
$calc -> add(12); 
$calc -> add(2); 
$calc -> sub(1); 
$calc -> mut(3); 
$calc -> div(2); 
$calc -> add(1.5); 
echo "Total: ".$calc -> total()."";
$calc -> clear();

?>