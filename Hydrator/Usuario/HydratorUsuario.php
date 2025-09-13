<?php

namespace Budgetlance\Hydrator\Usuario;

use Budgetlance\Model\Site\Usuario\ModelUsuario;

class HydratorUsuario
{
    public static function fromDatabase(array $row): ModelUsuario
    {
        $usuario = new ModelUsuario($row['nm_usuario'], $row['email'], $row['senha'], true);

        $usuario->setIdUsuario((int) $row['id']);
        return $usuario;
    }
}