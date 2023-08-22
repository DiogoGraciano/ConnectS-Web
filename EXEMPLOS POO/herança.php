<?php
class post{
   private int $id;
   private int $like;
   
   protected function setid($i){
        $this -> id = $i;
        $this -> setlike(90);
    }
   public function getid(){
        return $this -> id;
    }
    protected function setlike($l){
        $this -> like = $l;
    }
   public function getlike(){
        return $this -> like;
    }
}
class foto extends post{
    private string $url = '';
   
   public function __construct($id){
        $this -> setid($id);
    }
   public function geturl(){
        return $this -> url;
    }
    public function seturl($u){
        $this -> url = $u;
    }
}

$foto = new foto(1);
$foto -> seturl('abc');

echo "URL: ".$foto -> geturl()." Likes:".$foto -> getlike()." ID foto:".$foto -> getid()."";


?>
