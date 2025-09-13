<?php

namespace Budgetlance\Model\Site\Servico;

class ModelServico {
    private $descricao;
    private $valor;
    private $prazo;

    /**
     * Construtor da classe Servicos
     * 
     * @param string $descricao Descrição do serviço
     * @param float $valor Valor do serviço
     * @param int $prazo Prazo de entrega em dias
     * @throws \InvalidArgumentException Se os parâmetros forem inválidos
     */
    public function __construct($descricao, $valor, $prazo) {
        $this->setDescricao($descricao);
        $this->setValor($valor);
        $this->setPrazo($prazo);
    }

    /**
     * Define a descrição do serviço
     * 
     * @param string $descricao
     * @throws \InvalidArgumentException Se a descrição estiver vazia
     */
    private function setDescricao($descricao) {
        if (empty(trim($descricao))) {
            throw new \InvalidArgumentException("Descrição do serviço não pode estar vazia");
        }
        $this->descricao = trim($descricao);
    }

    /**
     * Define o valor do serviço
     * 
     * @param float $valor
     * @throws \InvalidArgumentException Se o valor for negativo
     */
    private function setValor($valor) {
        if (!is_numeric($valor) || $valor < 0) {
            throw new \InvalidArgumentException("Valor do serviço deve ser um número positivo");
        }
        $this->valor = (float) $valor;
    }

    /**
     * Define o prazo do serviço
     * 
     * @param int $prazo
     * @throws \InvalidArgumentException Se o prazo for negativo
     */
    private function setPrazo($prazo) {
        if (!is_numeric($prazo) || $prazo < 0) {
            throw new \InvalidArgumentException("Prazo deve ser um número positivo");
        }
        $this->prazo = (int) $prazo;
    }

    /**
     * Retorna a descrição do serviço
     * 
     * @return string
     */
    public function getDescricao() {
        return $this->descricao;
    }

    /**
     * Retorna o valor do serviço
     * 
     * @return float
     */
    public function getValor() {
        return $this->valor;
    }

    /**
     * Retorna o prazo do serviço em dias
     * 
     * @return int
     */
    public function getPrazo() {
        return $this->prazo;
    }

    /**
     * Retorna o valor formatado como moeda brasileira
     * 
     * @return string
     */
    public function getValorFormatado() {
        return 'R$ ' . number_format($this->valor, 2, ',', '.');
    }

    /**
     * Retorna uma representação em string do serviço
     * 
     * @return string
     */
    public function __toString() {
        return "{$this->descricao} - {$this->getValorFormatado()} (Prazo: {$this->prazo} dias)";
    }
    
}
// Exemplo de uso
try {
    $servico = new ModelServico("Adicione o Servico", [], []);
    echo $servico; // Saída: Desenvolvimento de site - R$ 1.500,50 (Prazo: 30 dias)
    echo $servico->getValorFormatado(); // Saída: R$ 1.500,50
} catch (\InvalidArgumentException $e) {
    echo "Erro: " . $e->getMessage();
}