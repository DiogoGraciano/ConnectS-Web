<?php 
namespace app\models\main;

use app\classes\functions;
use app\db\agenda;
use app\classes\mensagem;

class agendaModel{

    public static function get($cd = ""){
        return (new agenda)->get($cd);
    }

    public static function getAll(){
        return (new agenda)->getAll();
    }

    public static function getEvents($dt_inicio,$dt_fim){
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

    public static function delete($cd){
        return (new agenda)->delete($cd);
    }

}