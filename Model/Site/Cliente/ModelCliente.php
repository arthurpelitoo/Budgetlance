<?php

namespace Budgetlance\Model\Site\Cliente;

use Budgetlance\Dao\Site\Cliente\DaoCliente;
use Budgetlance\Model\Site\Orcamento\ModelOrcamento;
use Budgetlance\Model\Site\Servico\ModelServico;

class ModelCliente {
    private int $id, $id_usuario;
    private string $nm_cliente, $telefone, $email;

    public function __construct(?int $id_usuario, string $nm_cliente, ?string $telefone = null, ?string $email = null) 
    {
        $this->id_usuario = $id_usuario;
        $this->nm_cliente = $nm_cliente;
        $this->telefone = $telefone;
        $this->email = $email;
    }


    /**
     * Cria Cliente no molde da classe:
     */
            /**
             * Feito para chamar a validação do cadastro ou atualização do cliente
             */
            public static function createAndUpdateNewCliente(int $id_usuario, string $nm_cliente, ?string $telefone = null, ?string $email = null):self
            {
                /**
                 * cria um array para fazer validação
                 */
                $cleanData = [
                    'id_usuario' => $id_usuario,
                    'nome' => $nm_cliente,
                    'telefone' => $telefone,
                    'email' => $email
                ];

                /**
                 * faz a validação do cadastro de cliente
                 */
                self::validateInputCliente($cleanData);


                return new self($id_usuario, $nm_cliente, $telefone, $email);
            } 

    /**
     * É chamado para fazer validação de cadastro ou atualização de cliente.
     */
            private static function validateInputCliente(array $cleanData):void
            {
                /**
                 * Validação de nome:
                 */
                        /**
                         * Pergunta se o nome ta vazio
                         */
                        if(empty($cleanData['nome'])){
                            throw new \Budgetlance\Config\validationException("Erro no nome!", "Erro na validação do nome no cliente. Tente novamente com um nome preenchido.");

                        /**
                         * ou então pergunta se o nome apresenta mais de 30 caracteres
                         */
                        } else if(strlen($cleanData['nome']) > 30){
                            throw new \Budgetlance\Config\validationException("Erro no nome!", "Erro na validação do nome no cliente. Tente novamente com um nome menor de 30 caracteres ou menos.");
                        }

                        // Validação do telefone (opcional)
                        if (!empty($cleanData['telefone'])) {
                            if (!preg_match('/^[0-9\-\(\)\s]+$/', $cleanData['telefone'])) {
                                throw new \Budgetlance\Config\ValidationException(
                                    "Erro no telefone!", 
                                    "Telefone inválido, use apenas números e caracteres ( ) -."
                                );
                            } elseif(strlen($cleanData['telefone']) < 9) {
                                throw new \Budgetlance\Config\ValidationException(
                                    "Erro no telefone!", 
                                    "O telefone deve ter pelo menos 9 caracteres."
                                );
                            } elseif(strlen($cleanData['telefone']) > 15) {
                                throw new \Budgetlance\Config\ValidationException(
                                    "Erro no telefone!", 
                                    "O telefone deve ter 15 caracteres ou menos."
                                );
                            }
                        }

                        // Validação do email (opcional)
                        if (!empty($cleanData['email'])) {
                            if (!filter_var($cleanData['email'], FILTER_VALIDATE_EMAIL)) {
                                throw new \Budgetlance\Config\ValidationException(
                                    "Erro no email!", 
                                    "O email informado não é válido."
                                );
                            }
                        }
            }

            




    /**
     * GETTERS:
     */

        public function getIdCliente():int
        { 
            return $this->id; 
        }

        public function getIdUsuario():int
        {
            return $this->id_usuario;
        }

        public function getNomeCliente():string
        {
            return $this->nm_cliente;
        }

        public function getTelefoneCliente(): ?string
        {
            return $this->telefone;
        }

        public function getEmailCliente(): ?string
        {
            return $this->email;
        }

    /**
     * SETTERS:
     */
        public function setIdCliente(int $id) { $this->id = $id; }
        private function setIdUsuario(int $id_usuario) { $this->id_usuario = $id_usuario; }

}

// $cliente = new ModelCliente("Maria Silva", "maria@email.com");

// $orcamento1 = new ModelOrcamento($cliente0);
// $orcamento1->adicionarServico(new ModelServico("", [], []));
// $orcamento1->adicionarServico(new ModelServico("", [], []));

// echo $orcamento1;

// $orcamento1->atualizarStatus("Aprovado");

// echo "\n\nStatus atualizado:\n";
// echo $orcamento1;
?>
