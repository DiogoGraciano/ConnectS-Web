<?php
    class post{
        public int $id = 0;
        public int $a = 0;
        public array $b = [];
        private string $c;
    
        public function aumentaa() {
            $this->a++;
    }
        public function setc($a) {
            $this->c = $a;
    }
        public function getc(){
            return $this -> c;
    }
}
    $p = new post();
    $p -> setc('kkkk');
    $p2 = new post();
    $p2 -> setc('hehe');

    echo "1= likes = ".$p->a." autor = ".$p->getc()."<BR>";
    echo "2= likes = ".$p2->a." autor = ".$p2->getc()."<BR>";
    ?>