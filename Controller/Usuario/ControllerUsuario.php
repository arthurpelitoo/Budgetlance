<?php

namespace Budgetlance\Controller\Usuario;
/**
 * namespace serve pra definir caminhos para autoload de classes e para nao se confundir com metódos publicos do php. (o Composer precisa disso!)
 */

use Budgetlance\Config\sanitizador;
use Budgetlance\Controller\Controller;
use Budgetlance\Dao\Site\Usuario\DaoUsuario;
use Budgetlance\Model\Site\Usuario\ModelUsuario;

class ControllerUsuario extends Controller
{

    /**
     * Tudo para autenticação de usuario:
     */


        /**
         * limpará os dados enviados por formulario de login e cadastro
         */
        private function sanitizarUsuario():array
        {
            try{

                $nome = $_POST['nome'] ?? '';
                $email = $_POST['email'] ?? '';
                $senha = $_POST['senha'] ?? '';

                return [
                    'nome' => sanitizador::sanitizar($nome),
                    'email' => sanitizador::sanitizar($email),
                    'senha' => sanitizador::sanitizar($senha),
                ];
            } catch(\Exception $e){
                /**
                 * Catch para
                 * erro inesperado.
                 */
                error_log("[" . date("Y-m-d H:i:s") . "] Erro geral: " . $e->getMessage() . "\n");
                // salva o erro para mostrar no modal
                $_SESSION['errorTitle'] = "Erro interno!";
                $_SESSION['error'] = "Erro interno. Tente novamente mais tarde.";
                header("Location: /signUp");
                exit;
            }
        }

        /**
         * Para o formulario de CADASTRO DE USUARIO:
         */
            /**
             * metodo da rota para efetuar cadastro.
             */
            public function salvarUsuario():void
            {
                // faz a limpeza dos dados
                $cleanData = $this->sanitizarUsuario();

                // agora os dados vão ser preparados para serem incluidos no banco de dados.
                $this->persistirUsuario($cleanData);

            }

            /**
             * persistirUsuario pega os dados limpos e insere no molde(ModelUsuario),
             * logo após isso pega o molde retornado com a base do usuario dentro
             * e consolida a inserção no banco usando o DaoUsuario;
             */
            private function persistirUsuario(array $cleanData):void
            {
                try{

                    $nome = $cleanData['nome'];
                    $email = $cleanData['email'];
                    $senha = $cleanData['senha'];

                    /**
                     * usamos aqui um metodo de criar usuario na model para criar a base dentro do molde na model.
                     */
                    $usuario = ModelUsuario::createNewUsuario($nome, $email, $senha);

                    /**
                     * jogamos a base da ModelUsuario aqui para o metodo da DaoUsuario
                     * aí consolidamos o usuario no banco de dados.
                     */
                    $dao = new DaoUsuario();
                    $dao->createUsuario($usuario);

                    /**
                     * definimos a sessão de login do usuario para o site;
                     */
                    $_SESSION['usuario_id'] = $usuario->getIdUsuario();
                    $_SESSION['usuario_nome'] = $usuario->getNomeUsuario();
                    $_SESSION['usuario_tipo'] = $usuario->getTipoUsuario();

                    /**
                     * manda o usuario para a dashboard.
                     */
                    header("Location: /dashboard");
                    exit;

                } catch(\Budgetlance\Config\validationException $e){
                    /**
                     * Catch para
                     * Regra de negocio:
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro de Usuario no Cadastro: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = $e->getTitle();
                    $_SESSION['error'] = $e->getMessage();
                    header("Location: /signUp");
                    exit;
                } catch(\PDOException $e){
                    /**
                     * Catch para
                     * erro inesperado do banco
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro de Cadastro ou geral: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro no cadastro!";
                    $_SESSION['error'] = "Erro interno de cadastro. Tente novamente mais tarde.";
                    header("Location: /signUp");
                    exit;
                } catch(\Exception $e){
                    /**
                     * Catch para
                     * erro inesperado.
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro de Cadastro ou geral: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro no cadastro!";
                    $_SESSION['error'] = "Erro interno de cadastro. Tente novamente mais tarde.";
                    header("Location: /signUp");
                    exit;
                }
            }
            
        /**
         * Para o formulario de login do usuario:
         */
                /**
                 * metodo da rota para efetuar login.
                 */
                public function loginUsuario():void
                {
                    $cleanData = $this->sanitizarUsuario();

                    $this->validarUsuario($cleanData);

                }

                /**
                 * validarUsuario pega os dados limpos e pesquisa se o email existe por meio da DaoUsuario,
                 * coleta a pesquisa, com o molde da ModelUsuario
                 * para que possamos realizar uma verificação de que os dados estão corretos para permitir o login;
                 */
                private function validarUsuario(array $cleanData):void
                {
                    try{
                        $email = $cleanData['email'];
                        $senha = $cleanData['senha'];

                        $dao = new DaoUsuario();

                        /**
                         * o buscarPorEmail da Dao retorna ModelUsuario se achar pelo email ou então null se não encontrar pelo email.
                         * @param (string $email)
                         * @return \Budgetlance\Model\Site\Usuario\ModelUsuario|null
                         */
                        $usuario = $dao->buscarPorEmail($email); 
                        
                        /**
                         * aqui fazemos uso da validação de senha da ModelUsuario.
                         * se usuario(true) existir e a senha for valida(true)
                         * definimos a sessão de login do usuario para o site;
                         */
                        if($usuario && $usuario->validarSenha($senha)){
                            $_SESSION['usuario_id'] = $usuario->getIdUsuario();
                            $_SESSION['usuario_nome'] = $usuario->getNomeUsuario();
                            $_SESSION['usuario_tipo'] = $usuario->getTipoUsuario();

                            /**
                             * manda o usuario para a dashboard.
                             */
                            header("Location: /dashboard");
                            
                        }else{
                            /**
                             * aqui é feito uma "mentirinha do bem",
                             * pois não queremos facilitar dizendo "O EMAIL ESTÁ INCORRETO!" ou "A SENHA ESTÁ INCORRETA!",
                             * para pessoas usarem brute force para descobrir contas de terceiros e fazer login forçado.
                             */
                            throw new \Budgetlance\Config\validationException("Erro ao fazer login!", "Email ou senha incorretos");
                        }

                    } catch(\Budgetlance\Config\validationException $e){
                        error_log("[" . date("Y-m-d H:i:s") . "] Erro de Login ou geral: " . $e->getMessage() . "\n");
                        // salva o erro para mostrar no modal
                        $_SESSION['errorTitle'] = $e->getTitle();
                        $_SESSION['error'] = $e->getMessage();
                        header("Location: /login");
                        exit;

                    } catch(\PDOException $e){
                        /**
                         * Catch para
                         * erro inesperado do banco
                         */
                        error_log("[" . date("Y-m-d H:i:s") . "] Erro de Login ou geral: " . $e->getMessage() . "\n");
                        // salva o erro para mostrar no modal
                        $_SESSION['errorTitle'] = "Erro no Login!";
                        $_SESSION['error'] = "Erro interno de Login. Tente novamente mais tarde.";
                        header("Location: /login");
                        exit;
                    } catch(\Exception $e){
                        /**
                         * Catch para
                         * erro inesperado.
                         */
                        error_log("[" . date("Y-m-d H:i:s") . "] Erro de Login ou geral: " . $e->getMessage() . "\n");
                        // salva o erro para mostrar no modal
                        $_SESSION['errorTitle'] = "Erro no Login!";
                        $_SESSION['error'] = "Erro interno de Login. Tente novamente mais tarde.";
                        header("Location: /login");
                        exit;
                    }
                }    
        /**
         * FAZER LOGOUT:
         */     
                /**
                 * metodo de rota para fazer logout
                 */
                public function logoutUsuario()
                {
                    //limpa a sessão
                    $this->limparSessão();

                    //destrói a sessão
                    $this->destruirSessão();

                    header("Location: /home");
                    exit;
                }

                private function limparSessão()
                {
                    // Limpa todas as variáveis de sessão
                    $_SESSION = [];
                }

                private function destruirSessão()
                {
                    session_destroy();
                }
                
}
