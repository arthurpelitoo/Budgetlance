<?php

namespace Budgetlance\Hydrator\Usuario;

use Budgetlance\Model\Site\Usuario\ModelUsuario;

final class HydratorUsuario
{

    /**
     * Converte uma linha em um objeto Usuario
     */
    public static function fromRow(array $row): ModelUsuario
    {
        $usuario = new ModelUsuario($row['nm_usuario'], $row['email'], $row['senha'], true);

        $usuario->setIdUsuario($row['id']);
        return $usuario;
    }

    /**
     * Converte várias linhas em uma lista de objetos Usuario
     */
    public static function fromDatabase(array $rows): array
    {
        $usuarios = [];

        foreach ($rows as $row) {
            $usuarios[] = self::fromRow($row);
        }

        return $usuarios;
    }
}