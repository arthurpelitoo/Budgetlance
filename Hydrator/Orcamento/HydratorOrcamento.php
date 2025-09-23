<?php

namespace Budgetlance\Hydrator\Orcamento;

use Budgetlance\Model\Site\Orcamento\ModelOrcamento;
use DateTime;

final class HydratorOrcamento
{
    /**
     * Converte uma linha em um objeto Orcamento
     */
    public static function fromRow(array $row): ModelOrcamento
    {

        $orcamento = new ModelOrcamento(
            $row['id_cliente'],
            $row['id_usuario'],
            $row['id_cs'],
            $row['nm_orcamento'],
            $row['desc_orcamento'],
            $row['valor'],
            DateTime::createFromFormat("Y-m-d H:i:s", $row['prazo']),
            $row['status']
        );
        $orcamento->setIdOrcamento($row['id']);
        if(!empty($row['nm_cliente']) || !empty($row['nm_servico'])){
            $orcamento->setNmClienteOrcamento($row['nm_cliente']);
            $orcamento->setNmCategoriaServicoOrcamento($row['nm_servico']);
        }
        

        return $orcamento;
    }

    /**
     * Converte várias linhas em uma lista de objetos Orcamento
     */
    public static function fromDatabase(array $rows): array
    {
        $orcamentos = [];

        foreach ($rows as $row) {
            $orcamentos[] = self::fromRow($row);
        }

        return $orcamentos;
    }
}