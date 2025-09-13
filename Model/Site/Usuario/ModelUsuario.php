<?php

namespace Budgetlance\Model\Site\Usuario;

class ModelUsuario
{
    private int $id; 
    private string $nm_usuario, $email, $senha, $tipo_usuario = "usuario";

    public function __construct(string $nm_usuario, string $email, string $senha, bool $hashed = false)
    {
        $this->nm_usuario = $nm_usuario;
        $this->email = $email;
        
        /**
         * Se senha estiver $hashed == true então é $senha (já está hasheada).
         * Se senha estiver $hashed == false então precisará fazer o hash [password_hash($senha, PASSWORD_BCRYPT);]
         */
        $this->senha = $hashed ? $senha : password_hash($senha, PASSWORD_BCRYPT);
    }

    /**
     * Cria Usuario:
     */
            /**
             * Feito para chamar a validação do cadastro e criar o hash da senha do usuario.
             */
            public static function createNewUsuario(string $nm_usuario, string $email, string $senha):self
            {
                /**
                 * cria um array para fazer validação
                 */
                $cleanData = [
                    'nome' => $nm_usuario,
                    'email' => $email,
                    'senha' => $senha
                ];

                /**
                 * faz a validação do cadastro
                 */
                self::validateInputUsuario($cleanData);

                /**
                 * e se re-instancia agora fazendo o hash da senha via contruct(já que a senha ainda não foi hasheada).
                 */
                return new self($nm_usuario, $email, $senha);
            }

            /**
             * É chamado para fazer validação de cadastro.
             */
            private static function validateInputUsuario(array $cleanData):void
            {
                /**
                 * Validação de nome:
                 */
                        /**
                         * Pergunta se o nome ta vazio
                         */
                        if(empty($cleanData['nome'])){
                            throw new \Budgetlance\Config\validationException("Erro no nome!", "Erro na validação do nome. Tente novamente com um nome preenchido.");

                            /**
                             * ou então pergunta se o nome apresenta mais de 20 caracteres
                             */
                        } else if(strlen($cleanData['nome']) > 20){
                            throw new \Budgetlance\Config\validationException("Erro no nome!", "Erro na validação do nome. Tente novamente com um nome menor de 20 caracteres ou menos.");
                        }
                /**
                 * Validação de email:
                 */
                        /**
                         * Pergunta se o email ta vazio
                         */
                        if(empty($cleanData['email'])){
                            throw new \Budgetlance\Config\validationException("Erro no email!", "Erro na validação de email. Tente novamente com um email preenchido.");
                            
                            /**
                             * ou então pergunta se o email está formatado.
                             */
                        } else if(!filter_var($cleanData['email'], FILTER_VALIDATE_EMAIL)){
                            throw new \Budgetlance\Config\validationException("Erro no email!", "Erro na validação de email. Tente novamente com um email tendo a formatação correta.");

                            /**
                             * ou então pergunta se o email apresenta mais de 64 caracteres
                             */
                        } else if(strlen($cleanData['email']) > 64){
                            throw new \Budgetlance\Config\validationException("Email gigante!", "Erro na validação de email. Tente novamente com um email menor de no maximo 64 caracteres ou menos.");
                        }

                /**
                 * Validação de senha:
                 */
                        /**
                         * Pergunta se a senha ta vazia
                         */
                        if(empty($cleanData['senha'])){
                            throw new \Budgetlance\Config\validationException("Erro na senha!", "Erro na validação de senha. Coloque alguma senha.");

                            /**
                             * ou então pergunta se a senha apresenta menos de 6 caracteres
                             */
                        } else if(strlen($cleanData['senha']) < 6){
                            throw new \Budgetlance\Config\validationException("Erro na senha!", "Erro na validação de senha. A senha precisa ter mais de 6 caracteres.");

                            /**
                             * ou então pergunta se a senha apresenta mais de 20 caracteres
                             */
                        } else if (strlen($cleanData['senha']) > 20) {
                            throw new \Budgetlance\Config\validationException("Erro na senha!", "Erro na validação de senha. A senha precisa ter 20 caracteres ou menos.");
                        }

            }


    

    /**
     * Validação:
     */

    // não retorna senha, apenas verifica
        public function validarSenha(string $senha):bool
        {
            return password_verify($senha, $this->senha);
        }

    /**
     * GETTERS:
     */

        public function getIdUsuario():int{ return $this->id; }

        public function getNomeUsuario():string{ return $this->nm_usuario; }

        public function getEmailUsuario():string{ return $this->email; }

        // salvar no banco
        public function getSenhaHash():string
        {
            return $this->senha;
        }

        public function getTipoUsuario():string{ return $this->tipo_usuario; }
    /**
     * SETTERS:
     */

        public function setIdUsuario(int $id) { $this->id = $id; }

}

?>