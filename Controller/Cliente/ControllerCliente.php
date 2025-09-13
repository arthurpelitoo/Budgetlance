<?php

namespace Budgetlance\Controller\Cliente;
/**
 * namespace serve pra definir caminhos para autoload de classes e para nao se confundir com metódos publicos do php. (o Composer precisa disso!)
 */

use Budgetlance\Config\sanitizador;
use Budgetlance\Controller\Controller;
use Budgetlance\Dao\Site\Cliente\DaoCliente;
use Budgetlance\Model\Site\Cliente\ModelCliente;

class ControllerCliente extends Controller
{

    /**
     * Tudo para autenticação de Cliente:
     */


        /**
         * limpará os dados enviados por formulario de login e cadastro
         */
        private function sanitizarCliente():array
        {
            try{

                $nome = $_POST['nome'] ?? '';
                $telefone = $_POST['telefone'] ?? '';
                $email = $_POST['email'] ?? '';

                return [
                    'nome' => sanitizador::sanitizar($nome),
                    'telefone' => sanitizador::sanitizar($telefone),
                    'email' => sanitizador::sanitizar($email),
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
                header("Location: /dashboard/cliente");
                exit;
            }
        }

        /**
         * Para o formulario de CADASTRO ou ATUALIZAÇÃO DE Cliente:
         */
            /**
             * metodo da rota para efetuar cadastro ou atualização.
             */
            public function salvarCliente():void
            {
                parent::isProtected();

                // faz a limpeza dos dados
                $cleanData = $this->sanitizarCliente();

                // id vindo do formulário (pode estar vazio se for criação)
                $id = $_POST['id'] ?? null;

                if($id){
                    $this->atualizarCliente($id, $cleanData);
                }else{
                    // Se não há id, é INSERT.
                    $this->persistirCliente($cleanData);
                }

            }

            /**
             * persistirCliente é INSERÇÃO NO BANCO, é um cadastro novo!
             */

            /**
             * persistirCliente pega os dados limpos e insere no molde(ModelCliente),
             * logo após isso pega o molde retornado com a base do Cliente dentro
             * e consolida a inserção no banco usando o DaoCliente;
             */
            private function persistirCliente(array $cleanData):void
            {
                try{

                    $nome = $cleanData['nome'];
                    $telefone = $cleanData['telefone'];
                    $email = $cleanData['email'];

                    // pega o id do usuário logado
                    $idUsuario = $_SESSION['usuario_id'] ?? null;
                    
                    /**
                     * usamos aqui um metodo de criar Cliente nos moldes da model para criar a base a ser inserida no banco.
                     */
                    $cliente = ModelCliente::createAndUpdateNewCliente($idUsuario, $nome, $telefone, $email);

                    /**
                     * jogamos a base da ModelCliente aqui para o metodo da DaoCliente
                     * aí consolidamos o Cliente no banco de dados.
                     */
                    $dao = new DaoCliente();
                    $dao->createCliente($cliente);

                    /**
                     * manda o Usuario para a dashboard de cliente.
                     */
                    header("Location: /dashboard/cliente");
                    exit;

                    
                } catch(\Budgetlance\Config\validationException $e){
                    /**
                     * Catch para
                     * Regra de negocio:
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro no Cadastro de Cliente: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = $e->getTitle();
                    $_SESSION['error'] = $e->getMessage();
                    header("Location: /dashboard/cliente");
                    exit;
                } catch(\PDOException $e){
                    /**
                     * Catch para
                     * erro inesperado do banco
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro de Cadastro de Cliente ou geral: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro no cadastro!";
                    $_SESSION['error'] = "Erro interno de cadastro. Tente novamente mais tarde.";
                    header("Location: /dashboard/cliente");
                    exit;
                } catch(\Exception $e){
                    /**
                     * Catch para
                     * erro inesperado.
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro no Cadastro de Cliente: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro no cadastro!";
                    $_SESSION['error'] = "Erro interno de cadastro. Tente novamente mais tarde.";
                    header("Location: /dashboard/cliente");
                    exit;
                }
            }

            /**
             * faz a listagem para a tabela da pagina da dashboard de cliente.
             */

            public function listarClientes():array
            {
                try{

                    parent::isProtected();

                    // pega o id do usuário logado
                    $idUsuario = $_SESSION['usuario_id'] ?? null;

                    $dao = new DaoCliente();
                    return $dao->buscarClientes($idUsuario);
                
                }
                catch(\Budgetlance\Config\validationException $e){
                    /**
                     * Catch para
                     * Regra de negocio:
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na listagem de Cliente: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = $e->getTitle();
                    $_SESSION['error'] = $e->getMessage();
                    header("Location: /dashboard");
                    exit;
                } catch(\PDOException $e){
                    /**
                     * Catch para
                     * erro inesperado do banco
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro de listagem de Cliente ou geral: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro interno!";
                    $_SESSION['error'] = "Erro interno. Tente novamente mais tarde.";
                    header("Location: /dashboard");
                    exit;
                } catch(\Exception $e){
                    /**
                     * Catch para
                     * erro inesperado.
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro no listagem de Cliente: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro interno!";
                    $_SESSION['error'] = "Erro interno. Tente novamente mais tarde.";
                    header("Location: /dashboard");
                    exit;
                }
            }

            /**
             * faz UPDATE, uma atualização de registro para a tabela da pagina da dashboard de cliente.
             */

            private function atualizarCliente(int $id, array $cleanData):void
            {
                try{

                    parent::isProtected();

                    $nome = $cleanData['nome'];
                    $telefone = $cleanData['telefone'];
                    $email = $cleanData['email'];

                    // pega o id do usuário logado
                    $idUsuario = $_SESSION['usuario_id'] ?? null;

                    // cria o cliente atualizado
                    $cliente = ModelCliente::createAndUpdateNewCliente($idUsuario, $nome, $telefone, $email);

                    $cliente->setIdCliente($id);

                    // chama o DAO para atualizar
                    $dao = new DaoCliente();
                    $dao->updateCliente($cliente);

                    // redireciona para a dashboard
                    header("Location: /dashboard/cliente");
                    exit;
                
                } catch(\Budgetlance\Config\validationException $e){
                    /**
                     * Catch para
                     * Regra de negocio:
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Atualizacao de Cliente: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = $e->getTitle();
                    $_SESSION['error'] = $e->getMessage();
                    header("Location: /dashboard/cliente");
                    exit;
                } catch(\PDOException $e){
                    /**
                     * Catch para
                     * erro inesperado do banco
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Atualizacao de Cliente ou geral: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro no Cliente!";
                    $_SESSION['error'] = "Erro interno. Tente novamente mais tarde.";
                    header("Location: /dashboard/cliente");
                    exit;
                } catch(\Exception $e){
                    /**
                     * Catch para
                     * erro inesperado.
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Atualizacao de Cliente: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro no Cliente!";
                    $_SESSION['error'] = "Erro interno. Tente novamente mais tarde.";
                    header("Location: /dashboard/cliente");
                    exit;
                }
            }

            public function pegarPeloId(int $id): ?ModelCliente
            {

                try{

                    parent::isProtected();

                    // pega o id do usuário logado
                    $idUsuario = $_SESSION['usuario_id'] ?? null;

                    $dao = new DaoCliente();

                    $obj = $dao->buscarPeloId($idUsuario, $id);
                    
                    if($obj)
                    {
                        return $obj;
                    } else{
                        return null;
                    }
                
                } catch(\Budgetlance\Config\validationException $e){
                    /**
                     * Catch para
                     * Regra de negocio:
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Atualizacao de Cliente: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = $e->getTitle();
                    $_SESSION['error'] = $e->getMessage();
                    header("Location: /dashboard/cliente");
                    exit;
                } catch(\PDOException $e){
                    /**
                     * Catch para
                     * erro inesperado do banco
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Atualizacao de Cliente ou geral: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro no Cliente!";
                    $_SESSION['error'] = "Erro interno. Tente novamente mais tarde.";
                    header("Location: /dashboard/cliente");
                    exit;
                } catch(\Exception $e){
                    /**
                     * Catch para
                     * erro inesperado.
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Atualizacao de Cliente: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro no Cliente!";
                    $_SESSION['error'] = "Erro interno. Tente novamente mais tarde.";
                    header("Location: /dashboard/cliente");
                    exit;
                }
            }

            public function deletarCliente():void
            {
                try{
                    parent::isProtected();

                    $id = $_GET['id'] ?? null;
                    $id_usuario = $_SESSION['usuario_id'] ?? null;
                    
                    if(!$id){
                        throw new \Budgetlance\Config\validationException("Cliente inválido!", "Não foi possível identificar o cliente a ser excluído.");
                    }

                    $dao = new DaoCliente();
                    $dao->deleteCliente((int) $id, $id_usuario);

                    header("Location: /dashboard/cliente");
                    exit;

                }  catch(\Budgetlance\Config\validationException $e){
                    /**
                     * Catch para
                     * Regra de negocio:
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Exclusão de Cliente: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = $e->getTitle();
                    $_SESSION['error'] = $e->getMessage();
                    header("Location: /dashboard/cliente");
                    exit;
                } catch(\PDOException $e){
                    /**
                     * Catch para
                     * erro inesperado do banco
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Exclusão de Cliente ou geral: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro no Cliente!";
                    $_SESSION['error'] = "Erro interno. Tente novamente mais tarde.";
                    header("Location: /dashboard/cliente");
                    exit;
                } catch(\Exception $e){
                    /**
                     * Catch para
                     * erro inesperado.
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Exclusão de Cliente: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro no Cliente!";
                    $_SESSION['error'] = "Erro interno. Tente novamente mais tarde.";
                    header("Location: /dashboard/cliente");
                    exit;
                }
            }
               
}
