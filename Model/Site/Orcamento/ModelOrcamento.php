<?php

namespace Budgetlance\Model\Site\Orcamento;

use Budgetlance\Model\Site\Cliente\ModelCliente;
use Budgetlance\Model\Site\Servico\ModelServico;

class ModelOrcamento {
    private $cliente;
    private $servicos = [];
    private $status;
    private $remuneracoes = [];

    public function __construct(ModelCliente $cliente) {
        $this->cliente = $cliente;
        $this->status = "Pendente";
    }

    public function adicionarServico(ModelServico $servico) {
        $this->servicos[] = $servico;
    }

    public function calcularTotal() {
        $total = 0;
        foreach ($this->servicos as $servico) {
            $total += $servico->getValor();
        }
        return $total;
    }

    public function atualizarStatus($novoStatus) {
        $this->status = $novoStatus;
    }

    public function __toString() {
        $servicosStr = "";
        foreach ($this->servicos as $s) {
            $servicosStr .= $s . PHP_EOL;
        }
        $total = $this->calcularTotal();

        return "Orçamento para {$this->cliente->getNome()} ({$this->status}):\n"
            . $servicosStr
            . "Total: R$ {$total}";
    }   

    public function verRemuneracao(){
        $vAtual = 0;
        foreach ($this->remuneracoes as $remuneracao){
            $vAtual += $remuneracao-> getValor();
        }
        return $vAtual;
    }
}

?>