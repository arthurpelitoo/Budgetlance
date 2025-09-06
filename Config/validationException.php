<?php

/**
 * classe pra entregar e receber mensagens de erro personalizados.
 * usar apenas para tratar regras de negocio.
 */

namespace Budgetlance\Config;

class validationException extends \Exception
{
    private string $title;

    public function __construct(string $title, string $message)
    {
        $this->title = $title;
        parent::__construct($message);

    }

    public function getTitle(): string
    {
        return $this->title;
    }
}