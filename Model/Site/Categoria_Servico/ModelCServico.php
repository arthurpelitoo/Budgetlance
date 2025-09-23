<?php

namespace Budgetlance\Model\Site\Categoria_Servico;

class ModelCServico {
    private int $id, $id_usuario;
    private string $nome, $descricao;

    /**
     * Construtor da classe ModelCServico
     * 
     * @param int $id_usuario Id do usuario
     * @param string $nome Nome do serviço
     * @param string $descricao Descrição do serviço
     * @throws \InvalidArgumentException Se os parâmetros forem inválidos
     */
    public function __construct(?int $id_usuario, string $nome, ?string $descricao = null) {
        $this->id_usuario = $id_usuario;
        $this->nome = $nome;
        $this->descricao = $descricao;
    }

    /**
     * Feito para chamar a validação do cadastro ou atualização do serviço
     */
    public static function createAndUpdateCategoriaServico(int $id_usuario, string $nome, ?string $descricao = null):self
    {
        /**
         * cria um array para fazer validação
         */
        $cleanData = [
            'id_usuario' => $id_usuario,
            'nome' => $nome,
            'descricao' => $descricao,
        ];

        /**
         * faz a validação do cadastro de serviço
         */
        self::validateInputCategoriaServico($cleanData);


        return new self($id_usuario, $nome, $descricao);
    } 

    private static function validateInputCategoriaServico(array $cleanData):void
    {
        /**
         * Validação de nome:
         */
                /**
                 * Pergunta se o nome ta vazio
                 */
                if(empty($cleanData['nome'])){
                    throw new \Budgetlance\Config\validationException("Erro no nome!", "Erro na validação do nome do Serviço. Tente novamente com um nome preenchido.");

                /**
                 * ou então pergunta se o nome apresenta mais de 30 caracteres
                 */
                } else if(strlen($cleanData['nome']) > 30){
                    throw new \Budgetlance\Config\validationException("Erro no nome!", "Erro na validação do nome do Serviço. Tente novamente com um nome menor de 30 caracteres ou menos.");
                }

                // Validação de descricao (opcional)
                if(strlen($cleanData['descricao']) > 240){
                    throw new \Budgetlance\Config\validationException("Erro na descricao!", "Erro na validação da descrição do Serviço. Tente novamente com uma descrição menor de 240 caracteres ou menos.");
                }
    }

    /**
     * Retorna o id da categoria de servico
     * @return int
     */

    public function getIdCategoriaServico():int
    { 
        return $this->id; 
    }

    /**
     * Retorna o id do usuario que faz o servico
     * @return int
     */

    public function getIdUsuario():int
    {
        return $this->id_usuario;
    }

    /**
     * Retorna o nome do serviço
     * 
     * @return string
     */
    public function getNomeCategoriaServico():string {
        return $this->nome;
    }
    
    /**
     * Retorna a descricao do serviço
     * 
     * @return string
     */
    public function getDescricaoCategoriaServico():string {
        return $this->descricao;
    }

    /**
     * SETTERS:
     */
        public function setIdCategoriaServico(int $id) { $this->id = $id; }

    // /**
    //  * Define o valor do serviço
    //  * 
    //  * @param float $valor
    //  * @throws \InvalidArgumentException Se o valor for negativo
    //  */
    // private function setValor($valor) {
    //     if (!is_numeric($valor) || $valor < 0) {
    //         throw new \InvalidArgumentException("Valor do serviço deve ser um número positivo");
    //     }
    //     $this->valor = (float) $valor;
    // }

    // /**
    //  * Define o prazo do serviço
    //  * 
    //  * @param int $prazo
    //  * @throws \InvalidArgumentException Se o prazo for negativo
    //  */
    // private function setPrazo($prazo) {
    //     if (!is_numeric($prazo) || $prazo < 0) {
    //         throw new \InvalidArgumentException("Prazo deve ser um número positivo");
    //     }
    //     $this->prazo = (int) $prazo;
    // }

    // /**
    //  * Retorna o valor do serviço
    //  * 
    //  * @return float
    //  */
    // public function getValor() {
    //     return $this->valor;
    // }

    // /**
    //  * Retorna o prazo do serviço em dias
    //  * 
    //  * @return int
    //  */
    // public function getPrazo() {
    //     return $this->prazo;
    // }

    // /**
    //  * Retorna o valor formatado como moeda brasileira
    //  * 
    //  * @return string
    //  */
    // public function getValorFormatado() {
    //     return 'R$ ' . number_format($this->valor, 2, ',', '.');
    // }

    // /**
    //  * Retorna uma representação em string do serviço
    //  * 
    //  * @return string
    //  */
    // public function __toString() {
    //     return "{$this->descricao} - {$this->getValorFormatado()} (Prazo: {$this->prazo} dias)";
    // }
    
}
// // Exemplo de uso
// try {
//     $servico = new ModelServico("Adicione o Servico", [], []);
//     echo $servico; // Saída: Desenvolvimento de site - R$ 1.500,50 (Prazo: 30 dias)
//     echo $servico->getValorFormatado(); // Saída: R$ 1.500,50
// } catch (\InvalidArgumentException $e) {
//     echo "Erro: " . $e->getMessage();
// }