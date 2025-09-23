<?php

namespace Budgetlance\Controller\Categoria_Servico;
/**
 * namespace serve pra definir caminhos para autoload de classes e para nao se confundir com metódos publicos do php. (o Composer precisa disso!)
 */

use Budgetlance\Config\Sanitizador;
use Budgetlance\Controller\Controller;
use Budgetlance\Dao\Site\Categoria_Servico\DaoCServico;
use Budgetlance\Model\Site\Categoria_Servico\ModelCServico;

final class ControllerCServico extends Controller
{

    /**
     * Tudo para autenticação de Categoria_Servico:
     */


        /**
         * limpará os dados enviados por formulario de login e cadastro
         */
        private function sanitizarCategoriaServico():array
        {
            try{

                $nome = $_POST['nome'] ?? '';
                $descricao = $_POST['descricao'] ?? '';

                return [
                    'nome' => Sanitizador::sanitizar($nome),
                    'descricao' => Sanitizador::sanitizar($descricao)
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
                header("Location: /dashboard/servico");
                exit;
            }
        }

        /**
         * Para o formulario de CADASTRO ou ATUALIZAÇÃO DE CategoriaServico:
         */
            /**
             * metodo da rota para efetuar cadastro ou atualização.
             */
            public function salvarCategoriaServico():void
            {
                parent::isProtected();

                // faz a limpeza dos dados
                $cleanData = $this->sanitizarCategoriaServico();

                // id vindo do formulário (pode estar vazio se for criação)
                $id = $_POST['id'] ?? null;

                if($id){
                    $this->atualizarCategoriaServico($id, $cleanData);
                }else{
                    // Se não há id, é INSERT.
                    $this->persistirCategoriaServico($cleanData);
                }

            }

            /**
             * persistirCategoriaServico é INSERÇÃO NO BANCO, é um cadastro novo!
             */

            /**
             * persistirCategoriaServico pega os dados limpos e insere no molde(ModelCategoriaServico),
             * logo após isso pega o molde retornado com a base do CategoriaServico dentro
             * e consolida a inserção no banco usando o DaoCategoriaServico;
             */
            private function persistirCategoriaServico(array $cleanData):void
            {
                try{

                    $nome = $cleanData['nome'];
                    $descricao = $cleanData['descricao'];

                    // pega o id do usuário logado
                    $usuario = $_SESSION['logado'];
                    $idUsuario = $usuario->getIdUsuario() ?? null;
                    
                    /**
                     * usamos aqui um metodo de criar CategoriaServico nos moldes da model para criar a base a ser inserida no banco.
                     */
                    $categoriaServico = ModelCServico::createAndUpdateCategoriaServico($idUsuario, $nome, $descricao);

                    /**
                     * jogamos a base da ModelCategoriaServico aqui para o metodo da DaoCategoriaServico
                     * aí consolidamos o CategoriaServico no banco de dados.
                     */
                    $dao = new DaoCServico();
                    $dao->createCategoriaServico($categoriaServico);

                    /**
                     * manda o Usuario para a dashboard de CategoriaServico.
                     */
                    header("Location: /dashboard/servico");
                    exit;

                    
                } catch(\Budgetlance\Config\validationException $e){
                    /**
                     * Catch para
                     * Regra de negocio:
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro no Cadastro de Categoria Servico: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = $e->getTitle();
                    $_SESSION['error'] = $e->getMessage();
                    header("Location: /dashboard/servico");
                    exit;
                } catch(\PDOException $e){
                    /**
                     * Catch para
                     * erro inesperado do banco
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro de Cadastro de Categoria Servico ou geral: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro no cadastro!";
                    $_SESSION['error'] = "Erro interno de cadastro. Tente novamente mais tarde.";
                    header("Location: /dashboard/servico");
                    exit;
                } catch(\Exception $e){
                    /**
                     * Catch para
                     * erro inesperado.
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro no Cadastro de Categoria Servico: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro no cadastro!";
                    $_SESSION['error'] = "Erro interno de cadastro. Tente novamente mais tarde.";
                    header("Location: /dashboard/servico");
                    exit;
                }
            }

            /**
             * faz a listagem para a tabela da pagina da dashboard de CategoriaServico.
             */

            public function listarCategoriaServicos(): ?array
            {
                try{

                    parent::isProtected();

                    // pega o id do usuário logado
                    $usuario = $_SESSION['logado'];
                    $idUsuario = $usuario->getIdUsuario() ?? null;

                    $dao = new DaoCServico();
                    return $dao->buscarCategoriaServico($idUsuario);
                
                }
                catch(\Budgetlance\Config\validationException $e){
                    /**
                     * Catch para
                     * Regra de negocio:
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na listagem de Categoria Servico: " . $e->getMessage() . "\n");
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
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro de listagem de Categoria Servico ou geral: " . $e->getMessage() . "\n");
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
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro no listagem de Categoria Servico: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro interno!";
                    $_SESSION['error'] = "Erro interno. Tente novamente mais tarde.";
                    header("Location: /dashboard");
                    exit;
                }
            }

            /**
             * faz UPDATE, uma atualização de registro para a tabela da pagina da dashboard de CategoriaServico.
             */

            private function atualizarCategoriaServico(int $id, array $cleanData):void
            {
                try{

                    parent::isProtected();

                    $nome = $cleanData['nome'];
                    $descricao = $cleanData['descricao'];

                    // pega o id do usuário logado
                    $usuario = $_SESSION['logado'];
                    $idUsuario = $usuario->getIdUsuario() ?? null;

                    // cria o CategoriaServico atualizado
                    $categoriaServico = ModelCServico::createAndUpdateCategoriaServico($idUsuario, $nome, $descricao);

                    $categoriaServico->setIdCategoriaServico($id);

                    // chama o DAO para atualizar
                    $dao = new DaoCServico();
                    $dao->updateCategoriaServico($categoriaServico);

                    // redireciona para a dashboard
                    header("Location: /dashboard/servico");
                    exit;
                
                } catch(\Budgetlance\Config\validationException $e){
                    /**
                     * Catch para
                     * Regra de negocio:
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Atualizacao de Categoria Servico: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = $e->getTitle();
                    $_SESSION['error'] = $e->getMessage();
                    header("Location: /dashboard/servico");
                    exit;
                } catch(\PDOException $e){
                    /**
                     * Catch para
                     * erro inesperado do banco
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Atualizacao de Categoria Servico ou geral: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro na Categoria de Servico!";
                    $_SESSION['error'] = "Erro interno. Tente novamente mais tarde.";
                    header("Location: /dashboard/servico");
                    exit;
                } catch(\Exception $e){
                    /**
                     * Catch para
                     * erro inesperado.
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Atualizacao de Categoria Servico: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro na Categoria de Servico!";
                    $_SESSION['error'] = "Erro interno. Tente novamente mais tarde.";
                    header("Location: /dashboard/servico");
                    exit;
                }
            }

            public function pegarPeloId(int $id): ?ModelCServico
            {

                try{

                    parent::isProtected();

                    // pega o id do usuário logado
                    $usuario = $_SESSION['logado'];
                    $idUsuario = $usuario->getIdUsuario() ?? null;

                    $dao = new DaoCServico();

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
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Atualizacao de Categoria Servico: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = $e->getTitle();
                    $_SESSION['error'] = $e->getMessage();
                    header("Location: /dashboard/servico");
                    exit;
                } catch(\PDOException $e){
                    /**
                     * Catch para
                     * erro inesperado do banco
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Atualizacao de Categoria Servico ou geral: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro na Categoria de Servico!";
                    $_SESSION['error'] = "Erro interno. Tente novamente mais tarde.";
                    header("Location: /dashboard/servico");
                    exit;
                } catch(\Exception $e){
                    /**
                     * Catch para
                     * erro inesperado.
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Atualizacao de Categoria Servico: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro na Categoria de Servico!";
                    $_SESSION['error'] = "Erro interno. Tente novamente mais tarde.";
                    header("Location: /dashboard/servico");
                    exit;
                }
            }

            public function deletarCategoriaServico(int $id):void
            {
                try{
                    parent::isProtected();
                    
                    $usuario = $_SESSION['logado'];
                    $idUsuario = $usuario->getIdUsuario() ?? null;
                    
                    if(!$id){
                        throw new \Budgetlance\Config\validationException("Categoria de Servico inválido!", "Não foi possível identificar a Categoria de Servico a ser excluída.");
                    }

                    $dao = new DaoCServico();
                    $dao->deleteCategoriaServico((int) $id, $idUsuario);

                    header("Location: /dashboard/servico");
                    exit;

                }  catch(\Budgetlance\Config\validationException $e){
                    /**
                     * Catch para
                     * Regra de negocio:
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Exclusão de Categoria Servico: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = $e->getTitle();
                    $_SESSION['error'] = $e->getMessage();
                    header("Location: /dashboard/servico");
                    exit;
                } catch(\PDOException $e){
                    /**
                     * Catch para
                     * erro inesperado do banco
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Exclusão de Categoria Servico ou geral: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro na Categoria de Servico!";
                    $_SESSION['error'] = "Erro interno. Tente novamente mais tarde.";
                    header("Location: /dashboard/servico");
                    exit;
                } catch(\Exception $e){
                    /**
                     * Catch para
                     * erro inesperado.
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Exclusão de Categoria Servico: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro na Categoria de Servico!";
                    $_SESSION['error'] = "Erro interno. Tente novamente mais tarde.";
                    header("Location: /dashboard/servico");
                    exit;
                }
            }
               
}
