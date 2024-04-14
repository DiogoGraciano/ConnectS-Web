<?php 
namespace app\models\main;

use app\classes\functions;
use app\db\agenda;
use app\classes\mensagem;

/**
 * Classe agendaModel
 * 
 * Esta classe fornece métodos para interagir com os dados dos agendamentos.
 * Ela utiliza a classe agenda para realizar operações de consulta no banco de dados.
 * 
 * @package app\models\main
 */
class agendaModel{

    /**
     * Obtém um registro específico da tabela 'agenda' com base no código.
     *
     * @param string $cd Código do registro a ser obtido.
     * @return mixed Retorna o registro encontrado ou null se nenhum registro for encontrado.
     */
    public static function get($cd = ""){
        return (new agenda)->get($cd);
    }

    /**
     * Obtém todos os registros da tabela 'agenda'.
     *
     * @return array Retorna um array contendo todos os registros da tabela 'agenda'.
     */
    public static function getAll(){
        return (new agenda)->getAll();
    }

    /**
     * Obtém eventos entre duas datas específicas.
     *
     * @param string $dt_inicio Data inicial.
     * @param string $dt_fim Data final.
     * @return string Retorna um JSON contendo os eventos encontrados.
     */
    public static function getEvents(string $dt_inicio,string $dt_fim){
        $agenda = new agenda;
        $results = $agenda->addFilter("dt_inicio",">=",$dt_inicio)->addFilter("dt_fim","<=",$dt_fim)->selectAll();

        $return = [];

        if ($results){
            foreach ($results as $result){
                $return[] = [
                    'id' => $result->cd_agenda,
                    'title' => $result->titulo,
                    'color' => $result->cor,
                    'start' => $result->dt_inicio,
                    'end' => $result->dt_fim,
                ];
            }
        }
        return json_encode($return);
    }

     /**
     * Insere ou atualiza um registro na tabela 'agenda'.
     *
     * @param mixed $cd_cliente Código do cliente.
     * @param mixed $cd_funcionario Código do funcionário.
     * @param mixed $titulo Título do evento.
     * @param mixed $dt_inicio Data de início do evento.
     * @param mixed $dt_fim Data de fim do evento.
     * @param mixed $cor Cor do evento.
     * @param mixed $obs Observação do evento.
     * @param mixed $status Status do evento.
     * @param mixed $cd_agenda (Opcional) Código da agenda para atualização.
     * @return mixed Retorna o ID do registro inserido ou atualizado ou false em caso de erro.
     */
    public static function set($cd_cliente,$cd_funcionario,$titulo,$dt_inicio,$dt_fim,$cor,$obs,$status,$cd_agenda=""){

        $agenda = new agenda;

        if (!clienteModel::get($cd_cliente)->cd_cliente){
            mensagem::setErro("Cliente não existe");
            return False;
        }

        if (!funcionarioModel::get($cd_funcionario)->cd_funcionario){
            mensagem::setErro("Funcionario não existe");
            return False;
        }

        if (!$dt_inicio = functions::dateTimeBd($dt_inicio)){
            mensagem::setErro("Data Inicial informada invalida");
            return False;
        }

        if (!$dt_fim = functions::dateTimeBd($dt_fim)){
            mensagem::setErro("Data Final informada invalida");
            return False;
        }

        if (!$titulo || !$status){
            mensagem::setErro("Um dos campos obrigatorios *Titulo* ou *Status* não foi informado");
            return False;
        }

        if($cd_agenda && $cd_cliente && $cd_funcionario && $titulo && $dt_inicio && $dt_fim && $status){
        
            $values = self::get($cd_agenda);

            if (!$values->cd_agenda){
                mensagem::setErro("Agendamento não existe");
                return false;
            }

            $values->cd_agenda = $cd_agenda;
            $values->cd_cliente = $cd_cliente;
            $values->titulo = $titulo;
            $values->cd_funcionario = $cd_funcionario;
            $values->dt_inicio= $dt_inicio;
            $values->dt_fim = $dt_fim;
            $values->cor = $cor;
            $values->obs= $obs;
            $values->status = $status;

            $retorno = $agenda->store($values);

            if ($retorno == true){
                mensagem::setSucesso("Atualizado com Sucesso");
                return $agenda->getLastId();
            }
            else {
                mensagem::setErro("Erro ao execultar a ação tente novamente");
                return False;
            }

        }
        elseif(!$cd_agenda && $cd_cliente && $cd_funcionario && $titulo && $dt_inicio && $dt_fim && $status){
            $values = $agenda->getObject();

            $values->cd_cliente = $cd_cliente;
            $values->cd_funcionario = $cd_funcionario;
            $values->titulo = $titulo;
            $values->dt_inicio= $dt_inicio;
            $values->dt_fim = $dt_fim;
            $values->cor = $cor;
            $values->obs= $obs;
            $values->status = $status;

            $retorno = $agenda->store($values);

            if ($retorno == true){
                mensagem::setSucesso("Criado com Sucesso");
                return $agenda->getLastId();
            }
            else {
                mensagem::setErro("Erro ao execultar a ação tente novamente");
                return False;
            }
        }
        else{
            mensagem::setErro("Erro ao excultar ação tente novamente");
            return False;
        }
    }

    /**
     * Deleta um registro da tabela 'agenda' com base no código.
     *
     * @param int $cd Código do registro a ser deletado.
     * @return bool Retorna true se o registro foi deletado com sucesso, caso contrário, retorna false.
     */
    public static function delete(int $cd){
        return (new agenda)->delete($cd);
    }

}