<?php

namespace Budgetlance\Model\Site\Orcamento;

use Budgetlance\Controller\Categoria_Servico\ControllerCServico;
use Budgetlance\Controller\Cliente\ControllerCliente;
use Budgetlance\Dao\Site\Cliente\DaoCliente;
use DateTime;

class ModelOrcamento {

    /**
     * servem apenas para o proposito de listagem:
     */
    private ?string $nmCliente = null;
    private ?string $nmServico = null;

    private int $id, $id_cliente, $id_usuario, $id_cs;
    private string $nm_orcamento, $desc_orcamento;
    private float $valor;
    private DateTime $prazo;
    private string $status;

    public function __construct(
        int $id_cliente,
        int $id_usuario,
        int $id_cs,
        string $nm_orcamento,
        string $desc_orcamento,
        float $valor,
        DateTime $prazo,
        string $status = "pendente"
        ) {
            $this->id_cliente = $id_cliente;
            $this->id_usuario = $id_usuario;
            $this->id_cs = $id_cs;
            $this->nm_orcamento = $nm_orcamento;
            $this->desc_orcamento = $desc_orcamento;
            $this->valor = $valor;
            $prazoFormatado = $prazo->setTime(0, 0, 0);
            $this->prazo = $prazoFormatado;

            $validStatuses = ['pendente','enviado','aprovado','recusado','concluido','cancelado','expirado'];
            $this->status  = in_array($status, $validStatuses) ? $status : "pendente";
        
    }

    /**
     * Cria Orcamento no molde da classe:
     */
            /**
             * Feito para chamar a validação do cadastro ou atualização do orcamento
             */
            public static function createAndUpdateNewOrcamento(int $id_usuario, int $id_cliente, int $id_categoriaservico, string $nm_orcamento, string $desc_orcamento, float $valor, DateTime $prazo, string $status):self
            {
                /**
                 * cria um array para fazer validação
                 */
                $cleanData = [
                    'id_usuario' => $id_usuario,
                    'id_cliente' => $id_cliente,
                    'id_categoriaservico' => $id_categoriaservico,
                    'nome' => $nm_orcamento,
                    'descricao' => $desc_orcamento,
                    'valor' => $valor,
                    'prazo' => $prazo,
                    'status' => $status
                ];

                /**
                 * faz a validação do cadastro de orcamento
                 */
                self::validateInputOrcamento($cleanData);

                return new self($id_cliente, $id_usuario, $id_categoriaservico, $nm_orcamento, $desc_orcamento, $valor, $prazo, $status);
            } 

    /**
     * É chamado para fazer validação de cadastro ou atualização de orcamento.
     */
            private static function validateInputOrcamento(array $cleanData):void
            {

                /**
                 * Validação de Cliente
                 */
                    if(empty($cleanData['id_cliente'])){
                        throw new \Budgetlance\Config\validationException(
                            "Erro no status!",
                            "Cliente inválido. Informe um cliente preenchido."
                        );
                    } else if(isset($cleanData['id_cliente'])){

                        $controllerCliente = new ControllerCliente();

                        $cliente = $controllerCliente->pegarPeloId((int) $cleanData['id_cliente']);

                        if (!$cliente) {
                            throw new \Budgetlance\Config\validationException(
                                "Erro no cliente!",
                                "Nenhum cliente selecionado."
                            );
                        }
                    }


                /**
                 * Validação de Categoria de Serviço
                 */
                    if(empty($cleanData['id_categoriaservico'])){
                        throw new \Budgetlance\Config\validationException(
                            "Erro no status!",
                            "Serviço inválido. Informe um Serviço preenchido."
                        );
                    } else if(isset($cleanData['id_categoriaservico'])){
                        
                        $controllerServico = new ControllerCServico();

                        $categoriaServico = $controllerServico->pegarPeloId((int) $cleanData['id_categoriaservico']);

                        if (!$categoriaServico) {
                            throw new \Budgetlance\Config\validationException(
                                "Erro na Categoria de Serviço!",
                                "Nenhuma Categoria de Serviço selecionada."
                            );
                        }
                    }

                /**
                 * Validação de nome:
                 */
                        /**
                         * Pergunta se o nome ta vazio
                         */
                        if(empty($cleanData['nome'])){
                            throw new \Budgetlance\Config\validationException("Erro no nome!", "Erro na validação do nome no orcamento. Tente novamente com um nome preenchido.");

                        /**
                         * ou então pergunta se o nome apresenta mais de 50 caracteres
                         */
                        } else if(strlen($cleanData['nome']) > 50){
                            throw new \Budgetlance\Config\validationException("Erro no nome!", "Erro na validação do nome no orcamento. Tente novamente com um nome menor de 50 caracteres ou menos.");
                        }

                // Validação da descriçao
                        if (empty($cleanData['descricao'])) {
                            throw new \Budgetlance\Config\validationException("Erro na descrição!", "A descrição deste serviço no orçamento deve ser preenchida.");
                        } else if(strlen($cleanData['descricao']) > 240){
                            throw new \Budgetlance\Config\validationException("Erro na descrição!", "Erro na validação da descrição no orçamento. Tente novamente com uma descrição menor de 240 caracteres ou menos.");
                        }

                // Validação do valor
                        if (empty($cleanData['valor'])) {
                            throw new \Budgetlance\Config\validationException("Erro no valor!", "O valor deste serviço no orçamento deve ser preenchido.");
                        } else{

                            // Converte para float apenas para realizar uma comparação;
                            $valorComparativo = (float) $cleanData['valor'];

                            // Limite com base no DECIMAL(8,2) do banco;
                            $min = 0.01;
                            $max = 9999999.99;

                            // se valor for menor que o minimo, OU valor for maior que o maximo.
                            if ($valorComparativo < $min || $valorComparativo > $max) {

                                // number format trabalha com quatro parametros, 2 deles são opcionais, mas são bacanas aqui.
                                // o primeiro é o numero a ser formatado(tem que ser float)
                                // o segundo é quantidade maxima de numeros na parte do decimal, ou seja, depois da virgula, aqui são 2(precisa ser int).
                                // o terceiro é o separador na decimal, ao inves de ficar R$ 800000.00, ficará R$ 800000,00 graças à virgula substituindo. (precisa ser string se for mexer)
                                // o quarto é o dos mil, quando o numero bate nos mil, ele traz um caractere separador, tipo aqui(que no nosso caso é o ponto): R$ 1.900,00;


                                throw new \Budgetlance\Config\validationException(
                                    "Erro no valor!",
                                    "O valor deve estar entre R$ " . number_format($min, 2, ',', '.') . 
                                    " e R$ " . number_format($max, 2, ',', '.') . "."
                                );
                            }
                        }
                // Validação de Prazo
                        if (empty($cleanData['prazo']) || !($cleanData['prazo'] instanceof DateTime)) {
                            throw new \Budgetlance\Config\validationException(
                                "Erro no prazo!",
                                "Data inválida. Informe um prazo no formato correto."
                            );
                        } else{
                            // Valida formato "Y-m-d"
                            $prazoFormatado = $cleanData['prazo']->format("Y-m-d");

                            // Tenta recriar o objeto para garantir consistência
                            $dataValida = DateTime::createFromFormat("Y-m-d", $prazoFormatado);

                            if (!$dataValida || $dataValida->format("Y-m-d") !== $prazoFormatado) {
                                throw new \Budgetlance\Config\validationException(
                                    "Erro no prazo!",
                                    "Formato de data inválido. Use o formato correto."
                                );
                            }
                        }
                // Validação de Status
                        if(empty($cleanData['status'])){
                            throw new \Budgetlance\Config\validationException(
                                "Erro no status!",
                                "Status inválido. Informe um status preenchido."
                            );
                        } else{
                            $validStatuses = ['pendente','enviado','aprovado','recusado','concluido','cancelado','expirado'];
                            $status = $cleanData['status'];
                            if(!in_array($status, $validStatuses)){
                                throw new \Budgetlance\Config\validationException(
                                    "Erro no status!",
                                    "Status inválido. Informe um status que siga as opções."
                                );
                            }
                        }
            }

    /**
     * GETTERS:
     */

        public function getIdOrcamento():int
        { 
            return $this->id; 
        }

        public function getIdUsuario():int
        {
            return $this->id_usuario;
        }

        public function getIdCliente():int
        {
            return $this->id_cliente;
        }

        public function getNmCliente():string
        {
            return $this->nmCliente;
        }

        public function getIdCategoriaServico():int
        {
            return $this->id_cs;
        }

        public function getNmCategoriaServico():string
        {
            return $this->nmServico;
        }

        public function getNomeOrcamento():string
        {
            return $this->nm_orcamento;
        }

        public function getDescricaoOrcamento():string
        {
            return $this->desc_orcamento;
        }

        public function getValorOrcamento():float
        {
            return $this->valor;
        }

        public function getValorFormatadoOrcamento():string
        {
            return number_format($this->valor, 2, ',', '.');
        }

        public function getPrazoOrcamento():DateTime
        {
            return $this->prazo;
        }

        public function getPrazoFormatadoOrcamento(string $formato = 'Y-m-d'):string
        {
            return $this->prazo->format($formato);
        }

        public function getStatusOrcamento():string
        {
            return $this->status;
        }

    /**
     * SETTERS:
     */
        public function setIdOrcamento(int $id):void { $this->id = $id; }

        public function setNmClienteOrcamento(string $nmCliente):void { $this->nmCliente = $nmCliente; }

        public function setNmCategoriaServicoOrcamento(string $nmServico):void { $this->nmServico = $nmServico; }

}

?>