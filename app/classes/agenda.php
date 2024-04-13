<?php

namespace app\classes;

use app\classes\pagina;
use app\classes\mensagem;

/**
 * Classe agenda representa uma agenda de eventos.
 *
 * Esta classe estende a classe pagina e implementa funcionalidades específicas para exibir uma agenda de eventos.
 */
class agenda extends pagina
{
    /**
     * @var array $buttons Array que armazena os botões a serem exibidos na agenda.
     */
    private $buttons = [];

    /**
     * Exibe a agenda com os eventos fornecidos.
     *
     * @param string $action Ação a ser executada ao interagir com a agenda.
     * @param string $eventos JSON de eventos a serem exibidos na agenda.
     * @param int $slot_duration Duração do intervalo de tempo entre os slots da agenda, em minutos.
     */
    public function show(string $action,string $eventos,int $slot_duration = 30)
    {
        // Carrega o template da agenda
        $this->tpl = $this->getTemplate("agenda_template.html");
        
        // Instancia a classe mensagem para exibir mensagens
        $mensagem = new mensagem;
        
        // Configura as propriedades do template
        $this->tpl->mensagem = $mensagem->show(false);
        $this->tpl->action = $action;

        // Define a duração do slot
        if ($slot_duration >= 60) {
            $this->tpl->slot_duration = "01:00";
        } else {
            $this->tpl->slot_duration = "00:" . $slot_duration;
        }

        // Define os eventos a serem exibidos
        $this->tpl->events = $eventos;

        // Define a data e hora atual como data inicial
        $date = new \DateTimeImmutable();
        $this->tpl->initial_date = $date->format(\DateTimeInterface::ATOM);

        // Adiciona botões ao template
        foreach ($this->buttons as $button) {
            $this->tpl->button = $button;
            $this->tpl->block("BLOCK_BUTTON");
        }

        // Exibe o bloco do calendário
        $this->tpl->block("BLOCK_CALENDARIO");
        
        // Exibe o template
        $this->tpl->show();
    }

    /**
     * Adiciona um botão à agenda.
     *
     * @param string $button Botão a ser adicionado.
     */
    public function addButton(string $button)
    {
        $this->buttons[] = $button;
    }
}
