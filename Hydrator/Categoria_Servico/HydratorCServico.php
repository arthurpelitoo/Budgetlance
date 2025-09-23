<?php

namespace Budgetlance\Hydrator\Categoria_Servico;

use Budgetlance\Model\Site\Categoria_Servico\ModelCServico;

final class HydratorCServico
{
    /**
     * Converte uma linha em um objeto ModelCServico
     */
    public static function fromRow(array $row): ModelCServico
    {
        $servico = new ModelCServico(
            $row['id_usuario'],
            $row['nm_servico'],
            $row['desc_servico']
        );
        $servico->setIdCategoriaServico($row['id']);

        return $servico;
    }

    /**
     * Converte várias linhas em uma lista de objetos ModelCServico
     */
    public static function fromDatabase(array $rows): array
    {
        $servicos = [];

        foreach ($rows as $row) {
            $servicos[] = self::fromRow($row);
        }

        return $servicos;
    }
}