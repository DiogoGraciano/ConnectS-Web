<?php
    class calc{
        private float $n = 0;

        public function add($x){ 
            $this -> n = $this -> n + $x;    
        }
        public function sub($x){
            $this -> n = $this -> n - $x;
        }
        public function mut($x){
            $this -> n = $this -> n * $x;
        }
        public function div($x){
            $this -> n = $this -> n / $x;
        }
        public function total(){
            return $this -> n;
        } 
        public function clear(){
            $this -> n = 0;
        }           
}
?>