<?php

namespace Budgetlance\Hydrator\Cliente;

use Budgetlance\Model\Site\Cliente\ModelCliente;

final class HydratorCliente
{
    /**
     * Converte uma linha em um objeto Cliente
     */
    public static function fromRow(array $row): ModelCliente
    {
        $cliente = new ModelCliente(
            $row['id_usuario'],
            $row['nm_cliente'],
            $row['telefone'],
            $row['email']
        );
        $cliente->setIdCliente($row['id']);

        return $cliente;
    }

    /**
     * Converte várias linhas em uma lista de objetos Cliente
     */
    public static function fromDatabase(array $rows): array
    {
        $clientes = [];

        foreach ($rows as $row) {
            $clientes[] = self::fromRow($row);
        }

        return $clientes;
    }
}