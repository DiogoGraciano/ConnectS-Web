<?php
    class math{
        public static function somar($x,$y){
            return $x + $y;
        }
        public static int $a = 1;
}
//$m = new math();
//echo $m -> somar(10,20); 
echo math::somar(10,20);
echo math::$a
    
    ?>