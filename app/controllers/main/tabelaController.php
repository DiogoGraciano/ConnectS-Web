<?php 
namespace app\controllers\main;
use app\classes\head;
use app\db\db;
use app\classes\form;
use app\classes\mensagem;
use app\classes\menu;
use app\classes\footer;
use app\classes\controllerAbstract;
use app\classes\elements;
use app\classes\functions;
use Exception;

class tabelaController extends controllerAbstract{

    private $tabela;

    const nomes = [
        "cd_cliente" => "Código do Cliente",
        "nm_cliente" => "Nome do Cliente",
        "nr_loja" => "Número da Loja",
        "cd_conexao" => "Código de Conexão",
        "id_conexao" => "ID de Conexão",
        "nm_terminal" => "Nome do Terminal",
        "nm_programa" => "Nome do Programa",
        "nm_usuario" => "Nome do Usuário",
        "senha" => "Senha",
        "obs" => "Observação",
        "nr_caixa" => "Número do Caixa",
        "cd_login" => "Código de Login",
        "nm_usuario" => "Nome de Usuário",
        "cd_ramal" => "Código do Ramal",
        "nm_funcionario" => "Nome do Funcionário",
        "nr_ramal" => "Número do Ramal",
        "nr_telefone" => "Número do Telefone",
        "nr_ip" => "Número IP",
        "nm_usuario" => "Nome de Usuário",
        "cd_usuario" => "Código do Usuário",
        "nm_usuario" => "Nome do Usuário",
        "nm_sistema" => "Nome do Sistema",
        "nm_terminal" => "Nome do Terminal"
    ];

    private function getNomeAmigavel($coluna){
        if (array_key_exists($coluna,$this::nomes))
            return $this::nomes[$coluna];
        else 
            return $coluna;
    }

    private function getNomeColuna($coluna){
        if ($key = array_search($coluna,$this::nomes))
            return $key;
        else 
            return False;
    }

    public function index(){
        $head = new head();
        $head->show("Importar/Exportar","");

        $menu = new menu();
        $menu->addMenu($this->url."tabela/tabela_exportar/","Exportar")
            ->addMenu($this->url."tabela/tabela_importar/","Importar")
            ->addMenu($this->url,"Voltar");
        
        $menu->show("Selecione o Modo");

        $footer = new footer;
        $footer->show();
    }

    public function tabela_importar(){
        $head = new head();
        $head->show("Selecione a tabela","");

        $menu = new menu();
        $menu->addMenu($this->url."tabela/importar/".functions::encrypt("tb_cliente"),"Cliente")
            ->addMenu($this->url."tabela/Importar/".functions::encrypt("tb_conexao"),"Conexão")
            ->addMenu($this->url."tabela/importar/".functions::encrypt("tb_usuario"),"Usuario")
            ->addMenu($this->url."tabela/importar/".functions::encrypt("tb_ramal"),"Ramal")
            ->addMenu($this->url."tabela","Voltar");
        
        $menu->show("Selecione a tabela");

        $footer = new footer;
        $footer->show();
    }

    public function tabela_exportar(){
        $head = new head();
        $head->show("Selecione a tabela","");

        $menu = new menu();
        $menu->addMenu($this->url."tabela/exportar/".functions::encrypt("tb_cliente"),"Cliente")
            ->addMenu($this->url."tabela/exportar/".functions::encrypt("tb_conexao"),"Conexão")
            ->addMenu($this->url."tabela/exportar/".functions::encrypt("tb_usuario"),"Usuario")
            ->addMenu($this->url."tabela/exportar/".functions::encrypt("tb_ramal"),"Ramal")
            ->addMenu($this->url."tabela","Voltar");
        
        $menu->show("Selecione a tabela");

        $footer = new footer;
        $footer->show();
    }

    public function exportar($tabela=[]){

        if (array_key_exists(0,$tabela)){
            $head = new head();
            $head->show("Exportação","","Selecione as Colunas Desejadas");

            $form = new form($this->url."tabela/action/exportar/".$tabela[0]);
            
            $db = new db($this->tabela);
            $colunas = $db->getColumns();

            $elements = new elements();

            $customs = [];

            if ($colunas){
                $i = 0;
                $checked = true;
                $readonly = true;
                foreach ($colunas as $coluna){
                    $form->addCustomInput(2,$elements->checkbox($coluna,$this->getNomeAmigavel($coluna),false,$checked,$readonly));
                    if ($i == 0){
                        $checked = false;
                        $readonly = false;
                    }
                    if ($i == 6){
                        $form->setCustomInputs();
                        $i = 0;
                    }
                    $i++;
                }
            }
            $form->setCustomInputs();

            $form->setButton($elements->button("Executar","btn_carregar","submit"));
            $form->setButtonNoForm($elements->button("Voltar","btn_voltar","submit","btn btn-dark pt-2 btn-block","location.href='".$this->url."tabela/tabela_exportar'"));
            $form->show();

            $footer = new footer;
            $footer->show();

        }else{
            mensagem::setErro("Tabela não informada");
            header("location: ".$this->url."tabela/tabela_exportar");
        }
    }

    public function importar($tabela=[]){

        if (array_key_exists(0,$tabela)){
            $head = new head();
            $head->show("Importação","","Adicione o Arquivo para Importação");

            $form = new form($this->url."tabela/action/importar/".$tabela[0]);

            $elements = new elements();

            $form->setInputs($elements->input("arquivo","Arquivo para Importação:","",false,false,"","file"));

            $form->setInputs($elements->label("Tabela deve ser importada em formato csv com (;) e formatação UTF-8"));
            $form->setButton($elements->button("Executar","btn_carregar","submit"));
            $form->setButtonNoForm($elements->button("Voltar","btn_voltar","buttom","btn btn-dark pt-2 btn-block","location.href='".$this->url."tabela/tabela_importar'"));
            $form->show();
            $footer = new footer;
            $footer->show();
        }
        else{
            mensagem::setErro("Tabela não informada");
            header("location: ".$this->url."tabela/tabela_importar");
        }
    }
    
    public function action($tabela=[]){
        try{
            if (array_key_exists(0,$tabela) && array_key_exists(1,$tabela)){
                if ($tabela[0] == "exportar"){
                    if (array_key_exists(1,$tabela)){
                        $db = new db(functions::decrypt($tabela[1]));
                        $colunas = $db->getColumns();

                        $colunas_selecionada = [];
                        $culunas_amigaveis = [];

                        foreach ($colunas as $coluna){
                            if ($_POST[$coluna]){
                                $colunas_selecionada[] = $coluna;
                                $culunas_amigaveis[] = $this->getNomeAmigavel($coluna);
                            }
                        }

                        $resultados = $db->selectColumns(...$colunas_selecionada);

                        if ($resultados){

                            if (!file_exists("Arquivos/")){
                                mkdir("Arquivos/",777);
                            }

                            $arquivo  = fopen('Arquivos/Relatorio.csv', "w");
                            $nome = "Relatorio.csv";

                            fputcsv($arquivo, $culunas_amigaveis);

                            foreach ($resultados as $resultado){
                                fputcsv($arquivo, (array)$resultado,";");
                            }

                            fclose($arquivo);

                            $arquivoLocal = 'Arquivos/'.$nome; 
                            
                            if (!file_exists($arquivoLocal)) {
                                Mensagem::setErro("Não foi possivel gerar o relatorio");
                                return $this->url."exportar";
                            }
                            Mensagem::setSucesso("Exportado com sucesso");
                            header("location: ".$this->url."arquivos/Relatorio.csv");
                        }
                        else {
                            mensagem::setErro("Nenhum registro encontrado");
                            header("location: ".$this->url."tabela/exportar/".$tabela[1]);
                        }
                    }
                    else{
                        mensagem::setErro("Tabela não informada");
                        header("location: ".$this->url."tabela/tabela_importar");
                    }

                }
                elseif ($tabela[0] == "importar"){
                    $tmpName = $_FILES["arquivo"]["tmp_name"];
                    if(($arquivo = fopen($tmpName, 'r')) !== FALSE) {
                        $i = 0;
                        $rows = [];
                        while (($data = fgetcsv($arquivo, 1000, ";")) !== FALSE) {
                            $rows[] = $data;
                        } 
                            $tabelaDb = functions::decrypt($tabela[1]);
                            $db = new db($tabelaDb);
                            $colunas_db = $db->getColumns();
                            $colunas = [];
                            $tb = $db->getObject();
                            $r = 1;
                            foreach ($rows as $data){
                                $c = 0;
                                foreach ($data as $coluna){
                                    if ($i == 0){
                                        $colunas[] = $this->getNomeColuna($coluna);
                                        continue;
                                    } 
                                    if (in_array($colunas[$c],$colunas_db)){
                                        $col = $colunas[$c];
                                        $tb->$col = $coluna;
                                        $c++;
                                    }
                                    else {
                                        Mensagem::setErro("Coluna ({$this->getNomeAmigavel($colunas[$c])}) não encontrada na Tabela {$tabelaDb} na linha ".$r);
                                        header("location: ".$this->url."tabela/tabela_importar");
                                        return;
                                    }
                                    $db->store($tb);  
                                }
                                $r++;
                                $i++;
                            }
                            
                            fclose($arquivo);

                            Mensagem::setSucesso("Exportado com sucesso");
                            header("location: ".$this->url."tabela/tabela_importar");
                        }
                    }else{
                        Mensagem::setErro("Não foi possivel fazer a leitura do arquivo, tente novamente.");
                        header("location: ".$this->url."tabela/tabela_importar");
                    }
            }else{
                Mensagem::setErro("Modo não informado");
                header("location: ".$this->url."tabela/tabela_importar");
            }
        }
        catch (Exception $e){
            Mensagem::setErro($e->getMessage());
            return $this->url."tabela";
        }
    }
}