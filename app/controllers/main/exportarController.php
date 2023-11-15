<?php 
namespace app\controllers\main;
use app\classes\head;
use app\db\db;
use app\classes\form;
use app\classes\consulta;
use app\classes\mensagem;
use app\classes\footer;
use app\classes\controllerAbstract;

class exportarController extends controllerAbstract{

    private $tabela;

    public function index(){

        $this->tabela = $this->getList("tabela");

        $head = new head();
        $head->show("Exportação/Importação","");

        $form = new form("Exportação/Importação",$this->url."exportar/carregar/");

        $tabelas = array($form->getObjectOption("tb_ramal","Ramal"),
        $form->getObjectOption("tb_conexao","Conexão"),
        $form->getObjectOption("tb_usuario","Usuario"),
        $form->getObjectOption("tb_cliente","Cliente"));

        
        $modos = array($form->getObjectOption("Exportar","Importação"),
        $form->getObjectOption("Exportar","Exportação"));

        $form->setInputs($form->select("Modo","modo",$modos,$this->tabela));
        $form->setInputs($form->select("Selecione a tabela","tabela",$tabelas,$this->tabela));

        if ($this->tabela){
            $db = new db($this->tabela);
            $colunas = $db->getColumns();

            $customs = [];

            if ($colunas){
                foreach ($colunas as $coluna){
                    $customs[] = $form->getCustomInput(2,$form->checkbox($coluna,$coluna));
                }
                
                $customs = array_chunk($customs,6);
                
                $form->setCustomInputs($customs);
            }
        }

        $form->setButton($form->button("Carregar","btn_carregar","submit"));
        $form->setButton($form->button("Voltar","btn_voltar","buttom","btn btn-dark pt-2 btn-block","location.href='".$this->url."'"));
        $form->show();
        $footer = new footer;
        $footer->show();
    }
    public function exportar(){
        
    }
    public function carregar(){
        $this->setList("tabela",$_POST['tabela']);
        header("location: ".$this->url."exportar");
    }
    public function importar(){
            
    }   
}