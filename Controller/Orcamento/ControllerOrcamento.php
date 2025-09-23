<?php

namespace Budgetlance\Controller\Orcamento;
/**
 * namespace serve pra definir caminhos para autoload de classes e para nao se confundir com metódos publicos do php. (o Composer precisa disso!)
 */

use Budgetlance\Config\Sanitizador;
use Budgetlance\Controller\Controller;
use Budgetlance\Dao\Site\Categoria_Servico\DaoCServico;
use Budgetlance\Dao\Site\Cliente\DaoCliente;
use Budgetlance\Dao\Site\Orcamento\DaoOrcamento;
use Budgetlance\Model\Site\Orcamento\ModelOrcamento;
use DateTime;

final class ControllerOrcamento extends Controller
{

    /**
     * Tudo para autenticação de Orçamento:
     */

        /**
         * limpará os dados enviados por formulario de login e cadastro
         */
        private function sanitizarOrcamento():array
        {
            try{

                $id_cliente = $_POST['cliente'] ?? '';
                $id_categoriaservico = $_POST['categoriaservico'] ?? '';
                $nome = $_POST['nome'] ?? '';
                $descricao = $_POST['descricao'] ?? '';
                $valor = $_POST['valor'] ?? '';
                $prazo = $_POST['prazo'] ?? '';
                $status = $_POST['status'] ?? '';

                return [
                    'id_cliente' => $id_cliente,
                    'id_categoriaservico' => $id_categoriaservico,
                    'nome' => Sanitizador::sanitizar($nome),
                    'descricao' => Sanitizador::sanitizar($descricao),
                    'valor' => Sanitizador::sanitizar($valor),
                    'prazo' => Sanitizador::sanitizar($prazo),
                    'status' => Sanitizador::sanitizar($status)
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
                header("Location: /dashboard/orcamento");
                exit;
            }
        }

        /**
         * Para o formulario de CADASTRO ou ATUALIZAÇÃO DE Orcamento:
         */
            /**
             * metodo da rota para efetuar cadastro ou atualização.
             */
            public function salvarOrcamento():void
            {
                parent::isProtected();

                // faz a limpeza dos dados
                $cleanData = $this->sanitizarOrcamento();

                // id vindo do formulário (pode estar vazio se for criação)
                $id = $_POST['id'] ?? null;

                

                if($id){
                    $this->atualizarOrcamento($id, $cleanData);
                }else{
                    // Se não há id, é INSERT.
                    $this->persistirOrcamento($cleanData);
                }

            }

            /**
             * persistirOrcamento é INSERÇÃO NO BANCO, é um cadastro novo!
             */

            /**
             * persistirOrcamento pega os dados limpos e insere no molde(ModelOrcamento),
             * logo após isso pega o molde retornado com a base do Orcamento dentro
             * e consolida a inserção no banco usando o DaoOrcamento;
             */
            private function persistirOrcamento(array $cleanData):void
            {
                try{

                    $id_cliente = ((int) $cleanData['id_cliente']); // typecast necessario para a criação do objeto
                    $id_categoriaservico = ((int) $cleanData['id_categoriaservico']); // typecast necessario para a criação do objeto
                    $nome = $cleanData['nome'];
                    $descricao = $cleanData['descricao'];
                    $valor = ((float) $cleanData['valor']);
                    $prazo = DateTime::createFromFormat("Y-m-d", $_POST['prazo']);
                    $status = $cleanData['status'];

                    // pega o id do usuário logado
                    $usuario = $_SESSION['logado'];
                    $idUsuario = $usuario->getIdUsuario() ?? null;
                    
                    /**
                     * usamos aqui um metodo de criar Orcamento nos moldes da model para criar a base a ser inserida no banco.
                     */
                    $orcamento = ModelOrcamento::createAndUpdateNewOrcamento($idUsuario, $id_cliente, $id_categoriaservico, $nome, $descricao, $valor, $prazo, $status);

                    // var_dump($orcamento);
                    // exit;

                    /**
                     * jogamos a base da ModelOrcamento aqui para o metodo da DaoOrcamento
                     * aí consolidamos o Orcamento no banco de dados.
                     */
                    $dao = new DaoOrcamento();
                    $dao->createOrcamento($orcamento);

                    /**
                     * manda o Usuario para a dashboard de Orcamento.
                     */
                    header("Location: /dashboard/orcamento");
                    exit;

                    
                } catch(\Budgetlance\Config\validationException $e){
                    /**
                     * Catch para
                     * Regra de negocio:
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro no Cadastro de Orcamento: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = $e->getTitle();
                    $_SESSION['error'] = $e->getMessage();
                    header("Location: /dashboard/orcamento");
                    exit;
                } catch(\PDOException $e){
                    /**
                     * Catch para
                     * erro inesperado do banco
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro de Cadastro de Orcamento ou geral: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro no cadastro!";
                    $_SESSION['error'] = "Erro interno de cadastro. Tente novamente mais tarde.";
                    header("Location: /dashboard/orcamento");
                    exit;
                } catch(\Exception $e){
                    /**
                     * Catch para
                     * erro inesperado.
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro no Cadastro de Orcamento: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro no cadastro!";
                    $_SESSION['error'] = "Erro interno de cadastro. Tente novamente mais tarde.";
                    header("Location: /dashboard/orcamento");
                    exit;
                }
            }

            /**
             * faz a listagem para a tabela da pagina da dashboard de Orcamento.
             */

            public function listarOrcamentos(): ?array
            {
                try{

                    parent::isProtected();

                    // pega o id do usuário logado
                    $usuario = $_SESSION['logado'];
                    $idUsuario = $usuario->getIdUsuario() ?? null;

                    $dao = new DaoOrcamento();
                    return $dao->buscarOrcamento($idUsuario);
                
                }
                catch(\Budgetlance\Config\validationException $e){
                    /**
                     * Catch para
                     * Regra de negocio:
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na listagem de Orcamento: " . $e->getMessage() . "\n");
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
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro de listagem de Orcamento ou geral: " . $e->getMessage() . "\n");
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
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro no listagem de Orcamento: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro interno!";
                    $_SESSION['error'] = "Erro interno. Tente novamente mais tarde.";
                    header("Location: /dashboard");
                    exit;
                }
            }

            /**
             * faz UPDATE, uma atualização de registro para a tabela da pagina da dashboard de Orcamento.
             */

            private function atualizarOrcamento(int $id, array $cleanData):void
            {
                try{

                    $id_cliente = ((int) $cleanData['id_cliente']); // typecast necessario para a criação do objeto
                    $id_categoriaservico = ((int) $cleanData['id_categoriaservico']); // typecast necessario para a criação do objeto
                    $nome = $cleanData['nome'];
                    $descricao = $cleanData['descricao'];
                    $valor = ((float) $cleanData['valor']);
                    $prazo = DateTime::createFromFormat("Y-m-d", $_POST['prazo']);
                    $status = $cleanData['status'];

                    // pega o id do usuário logado
                    $usuario = $_SESSION['logado'];
                    $idUsuario = $usuario->getIdUsuario() ?? null;

                    // cria o Orcamento atualizado
                    $orcamento = ModelOrcamento::createAndUpdateNewOrcamento($idUsuario, $id_cliente, $id_categoriaservico, $nome, $descricao, $valor, $prazo, $status);

                    $orcamento->setIdOrcamento($id);

                    // chama o DAO para atualizar
                    $dao = new DaoOrcamento();
                    $dao->updateOrcamento($orcamento);

                    // redireciona para a dashboard
                    header("Location: /dashboard/orcamento");
                    exit;
                
                } catch(\Budgetlance\Config\validationException $e){
                    /**
                     * Catch para
                     * Regra de negocio:
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Atualizacao de Orcamento: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = $e->getTitle();
                    $_SESSION['error'] = $e->getMessage();
                    header("Location: /dashboard/orcamento");
                    exit;
                } catch(\PDOException $e){
                    /**
                     * Catch para
                     * erro inesperado do banco
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Atualizacao de Orcamento ou geral: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro no Orçamento!";
                    $_SESSION['error'] = "Erro interno. Tente novamente mais tarde.";
                    header("Location: /dashboard/orcamento");
                    exit;
                } catch(\Exception $e){
                    /**
                     * Catch para
                     * erro inesperado.
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Atualizacao de Orcamento: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro no Orçamento!";
                    $_SESSION['error'] = "Erro interno. Tente novamente mais tarde.";
                    header("Location: /dashboard/orcamento");
                    exit;
                }
            }

            public function pegarPeloCliente(): ?array
            {

                try{

                    parent::isProtected();

                    // pega o id do usuário logado
                    $usuario = $_SESSION['logado'];
                    $idUsuario = $usuario->getIdUsuario() ?? null;

                    $dao = new DaoCliente();

                    $obj = $dao->buscarIdEClientePeloUsuario($idUsuario);
                    
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
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Listagem de Cliente em Formulario de Orcamento: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = $e->getTitle();
                    $_SESSION['error'] = $e->getMessage();
                    header("Location: /dashboard/orcamento");
                    exit;
                } catch(\PDOException $e){
                    /**
                     * Catch para
                     * erro inesperado do banco
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Listagem de Cliente em Formulario de Orcamento ou geral: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro no Orçamento!";
                    $_SESSION['error'] = "Erro interno. Tente novamente mais tarde.";
                    header("Location: /dashboard/orcamento");
                    exit;
                } catch(\Exception $e){
                    /**
                     * Catch para
                     * erro inesperado.
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Listagem de Cliente em Formulario de Orcamento: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro no Orçamento!";
                    $_SESSION['error'] = "Erro interno. Tente novamente mais tarde.";
                    header("Location: /dashboard/orcamento");
                    exit;
                }
            }

            public function pegarPelaCategoriaServico(): ?array
            {

                try{

                    parent::isProtected();

                    // pega o id do usuário logado
                    $usuario = $_SESSION['logado'];
                    $idUsuario = $usuario->getIdUsuario() ?? null;

                    $dao = new DaoCServico();

                    $obj = $dao->buscarIdECatServicoPeloUsuario($idUsuario);
                    
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
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Listagem de Categoria de Servico em Formulario de Orcamento: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = $e->getTitle();
                    $_SESSION['error'] = $e->getMessage();
                    header("Location: /dashboard/orcamento");
                    exit;
                } catch(\PDOException $e){
                    /**
                     * Catch para
                     * erro inesperado do banco
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Listagem de Categoria de Servico em Formulario de Orcamento ou geral: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro no Orçamento!";
                    $_SESSION['error'] = "Erro interno. Tente novamente mais tarde.";
                    header("Location: /dashboard/orcamento");
                    exit;
                } catch(\Exception $e){
                    /**
                     * Catch para
                     * erro inesperado.
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Listagem de Categoria de Servico em Formulario de Orcamento: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro no Orçamento!";
                    $_SESSION['error'] = "Erro interno. Tente novamente mais tarde.";
                    header("Location: /dashboard/orcamento");
                    exit;
                }
            }

            public function pegarPeloId(int $id): ?ModelOrcamento
            {

                try{

                    parent::isProtected();

                    // pega o id do usuário logado
                    $usuario = $_SESSION['logado'];
                    $idUsuario = $usuario->getIdUsuario() ?? null;

                    $dao = new DaoOrcamento();

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
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Atualizacao de Orcamento: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = $e->getTitle();
                    $_SESSION['error'] = $e->getMessage();
                    header("Location: /dashboard/orcamento");
                    exit;
                } catch(\PDOException $e){
                    /**
                     * Catch para
                     * erro inesperado do banco
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Atualizacao de Orcamento ou geral: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro no Orçamento!";
                    $_SESSION['error'] = "Erro interno. Tente novamente mais tarde.";
                    header("Location: /dashboard/orcamento");
                    exit;
                } catch(\Exception $e){
                    /**
                     * Catch para
                     * erro inesperado.
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Atualizacao de Orcamento: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro no Orçamento!";
                    $_SESSION['error'] = "Erro interno. Tente novamente mais tarde.";
                    header("Location: /dashboard/orcamento");
                    exit;
                }
            }

            public function deletarOrcamento(int $id):void
            {
                try{
                    parent::isProtected();
                    
                    $usuario = $_SESSION['logado'];
                    $idUsuario = $usuario->getIdUsuario() ?? null;
                    
                    if(!$id){
                        throw new \Budgetlance\Config\validationException("Orçamento inválido!", "Não foi possível identificar o Orçamento a ser excluído.");
                    }

                    $dao = new DaoOrcamento();
                    $dao->deleteOrcamento((int) $id, $idUsuario);

                    header("Location: /dashboard/orcamento");
                    exit;

                }  catch(\Budgetlance\Config\validationException $e){
                    /**
                     * Catch para
                     * Regra de negocio:
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Exclusão de Orcamento: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = $e->getTitle();
                    $_SESSION['error'] = $e->getMessage();
                    header("Location: /dashboard/orcamento");
                    exit;
                } catch(\PDOException $e){
                    /**
                     * Catch para
                     * erro inesperado do banco
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Exclusão de Orcamento ou geral: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro no Orçamento!";
                    $_SESSION['error'] = "Erro interno. Tente novamente mais tarde.";
                    header("Location: /dashboard/orcamento");
                    exit;
                } catch(\Exception $e){
                    /**
                     * Catch para
                     * erro inesperado.
                     */
                    error_log("[" . date("Y-m-d H:i:s") . "] Erro na Exclusão de Orcamento: " . $e->getMessage() . "\n");
                    // salva o erro para mostrar no modal
                    $_SESSION['errorTitle'] = "Erro no Orçamento!";
                    $_SESSION['error'] = "Erro interno. Tente novamente mais tarde.";
                    header("Location: /dashboard/orcamento");
                    exit;
                }
            }
               
}
