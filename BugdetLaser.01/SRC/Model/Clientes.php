<?php

class Clientes {
    private $nome;
    private $contatos;

    public function __construct($nome, $contatos) {
        $this->nome = $nome;
        $this->contatos = $contatos;
    }

    public function getNome(){
        return $this->nome;
    }
}

$clientes = new clientes("Maria Silva", "maria@email.com");

$orcamento1 = new Orcamento($cliente0);
$orcamento1->adicionarServico(new Servicos("", [], []));
$orcamento1->adicionarServico(new Servicos("", [], []));

echo $orcamento1;

$orcamento1->atualizarStatus("Aprovado");

echo "\n\nStatus atualizado:\n";
echo $orcamento1;
?>
