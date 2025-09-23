<?php

namespace Budgetlance\Dao\Site\Categoria_Servico;

use Budgetlance\Dao\Connection;
use Budgetlance\Hydrator\Categoria_Servico\HydratorCliente;
use Budgetlance\Hydrator\Categoria_Servico\HydratorCServico;
use Budgetlance\Model\Site\Categoria_Servico\ModelCServico;

final class DaoCServico extends Connection
{

    // evita erro de digitação na hora de puxar a tabela na query.
    private const TABLE = 'categoria_servico';

    /**
     * Para criação de Servico:
     */

        public function createCategoriaServico(ModelCServico $servico): ModelCServico
        {
            try{
                $sql = "INSERT INTO " . self::TABLE . " (id_usuario, nm_servico, desc_servico) VALUES (:id_usuario, :nm_servico, :desc_servico) ";
                // essa é uma string de comando.

                //metodo de preparacao da string para inserção de dados.
                $stmt = Connection::getConnection()->prepare($sql);

                $stmt->bindValue(":id_usuario", $servico->getIdUsuario());
                $stmt->bindValue(":nm_servico", $servico->getNomeCategoriaServico());
                $stmt->bindValue(":desc_servico", $servico->getDescricaoCategoriaServico());
                $stmt->execute();

                $id = Connection::getConnection()->lastInsertId(); // <- aqui você pega o id do categoria recém-criado
                $servico->setIdCategoriaServico($id);

                return $servico;
                
            } catch(\PDOException $e){

                error_log("[" . date("Y-m-d H:i:s") . "] Erro dentro de createCategoriaServico: " . $e->getMessage() . "\n");
                throw $e;
            } catch(\Exception $e){
                error_log("[" . date("Y-m-d H:i:s") . "] Erro dentro de createCategoriaServico: " . $e->getMessage() . "\n");
                throw $e;
            }
        }
    /**
     * Para procurar Categoria:
     */

        /**
         * APENAS PARA O FORMULARIO DE ORÇAMENTO.
         */
        public function buscarIdECatServicoPeloUsuario(int $id_usuario): ?array
        {
            try{
                $sql = "SELECT id, nm_servico FROM " . self::TABLE . " WHERE id_usuario = :id_usuario ";
            
                $stmt = Connection::getConnection()->prepare($sql);
                $stmt->bindValue(":id_usuario", $id_usuario);
                $stmt->execute();

                /**
                 * O fetchAll() envia um array de array associativos,
                 * enviando varios registros, bom nesse caso, onde queremos os resultados especificos.
                 */
                $rows = $stmt->fetchAll();


                return $rows ?: null;
                // aqui já é array puro apenas para resgatar em selects dentro de operações CRUD, o que não envolve regra de negocio mesmo
            } catch(\PDOException $e){
                
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de buscarIdECatServicoPeloUsuario: " . $e->getMessage() . "\n");
                throw $e;
            } catch(\Exception $e){
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de buscarIdECatServicoPeloUsuario: " . $e->getMessage() . "\n");
                throw $e;
            }
        }

        public function buscarCategoriaServico(int $id_usuario): ?array
        {
            try{
                $sql = "SELECT * FROM " . self::TABLE . " WHERE id_usuario = :id_usuario ";
            
                $stmt = Connection::getConnection()->prepare($sql);
                $stmt->bindValue(":id_usuario", $id_usuario);
                $stmt->execute();

                /**
                 * O fetchAll() envia um array de array associativos,
                 * enviando varios registros, bom nesse caso, onde queremos os resultados especificos.
                 */
                $rows = $stmt->fetchAll();

                if($rows){
                    /**
                     * ele vai retornar os dados da query do banco para o Hydrator transformar o array associativo em objeto ModelCategoria e retornar isso pra ModelCategoria.
                     */
                    return HydratorCServico::fromDatabase($rows);
                }else{
                    return null;
                }
            } catch(\PDOException $e){
                
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de buscarCategoriaServico: " . $e->getMessage() . "\n");
                throw $e;
            } catch(\Exception $e){
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de buscarCategoriaServico: " . $e->getMessage() . "\n");
                throw $e;
            }
        }

        //verificação de acesso ao orçamento
        public function usuarioPossuiCadastro(int $id_usuario): bool
        {
            $sql = "SELECT 1 FROM " . self::TABLE . " WHERE id_usuario = :id_usuario LIMIT 1";
            $stmt = Connection::getConnection()->prepare($sql);
            $stmt->bindValue(":id_usuario", $id_usuario);
            $stmt->execute();

            return (bool) $stmt->fetchColumn();
        }

        //pra realizar a recuperação de Dados para update
        public function buscarPeloId(int $id_usuario, int $id): ?ModelCServico
        {
            try{
                $sql = "SELECT * FROM " . self::TABLE . " WHERE id_usuario = :id_usuario AND id = :id ";

                $stmt = Connection::getConnection()->prepare($sql);
                $stmt->bindValue(":id_usuario", $id_usuario);
                $stmt->bindValue(":id", $id);
                $stmt->execute();

                /**
                 * Aqui é feito apenas fetch por que:
                 * Quando fazemos uma busca por algo que deveria ser único no banco
                 * (ex: email em uma tabela de usuários),
                 * você espera que o SELECT retorne no máximo um registro.
                 * 
                 * com o fetchAll() ele enviaria um array de array associativos,
                 * enviando varios registros, o que seria meio ruim pra esse caso, onde queremos apenas algo unico, que tem apenas um resultado e é performatico.
                 */
                $row = $stmt->fetch();

                if($row){
                    /**
                     * ele vai retornar os dados da query do banco para o Hydrator transformar o array associativo em objeto ModelCategoria e retornar isso pra ModelCategoria.
                     */
                    return HydratorCServico::fromRow($row);
                }else{
                    return null;
                }
            } catch(\PDOException $e){
                
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de buscarPorId: " . $e->getMessage() . "\n");
                throw $e;
            } catch(\Exception $e){
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de buscarPorId: " . $e->getMessage() . "\n");
                throw $e;
            }
            
        }

        public function buscarPorNome(int $id_usuario, string $nome): ?array
        {
            try{
                $sql = "SELECT * FROM " . self::TABLE . " WHERE id_usuario = :id_usuario AND nm_servico = :nm_servico ";
            
                $stmt = Connection::getConnection()->prepare($sql);
                $stmt->bindValue(":id_usuario", $id_usuario);
                $stmt->bindValue(":nm_servico", $nome);
                $stmt->execute();

                /**
                 * O fetchAll() envia um array de array associativos,
                 * enviando varios registros, bom nesse caso, onde queremos os resultados especificos.
                 */
                $rows = $stmt->fetchAll();

                if($rows){
                    /**
                     * ele vai retornar os dados da query do banco para o Hydrator transformar o array associativo em objeto ModelCategoria e retornar isso pra ModelCategoria.
                     */
                    return HydratorCServico::fromDatabase($rows);
                }else{
                    return null;
                }
            } catch(\PDOException $e){
                
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de buscarPorNome: " . $e->getMessage() . "\n");
                throw $e;
            } catch(\Exception $e){
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de buscarPorNome: " . $e->getMessage() . "\n");
                throw $e;
            }
        }

        public function updateCategoriaServico(ModelCServico $servico):void
        {
            try{
                $sql = "UPDATE " . self::TABLE . " SET nm_servico = :nome, desc_servico = :desc_servico WHERE id = :id AND id_usuario = :id_usuario ";

                $stmt = Connection::getConnection()->prepare($sql);

                $stmt->bindValue(":nome", $servico->getNomeCategoriaServico());
                $stmt->bindValue(":desc_servico", $servico->getDescricaoCategoriaServico());
                $stmt->bindValue(":id", $servico->getIdCategoriaServico());
                $stmt->bindValue(":id_usuario", $servico->getIdUsuario());

                $stmt->execute();

            } catch(\PDOException $e){
                
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de updateCategoria: " . $e->getMessage() . "\n");
                throw $e;
            } catch(\Exception $e){
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de updateCategoria: " . $e->getMessage() . "\n");
                throw $e;
            }
            
        }

        public function deleteCategoriaServico(int $id, int $id_usuario): void
        {
            try{
                $sql = "DELETE FROM " . self::TABLE . " WHERE id = :id AND id_usuario = :id_usuario";

                $stmt = Connection::getConnection()->prepare($sql);

                $stmt->bindValue(":id", $id);
                $stmt->bindValue(":id_usuario", $id_usuario);

                $stmt->execute();
            }catch(\PDOException $e){
                
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de deleteCategoria: " . $e->getMessage() . "\n");
                throw $e;
            } catch(\Exception $e){
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de deleteCategoria: " . $e->getMessage() . "\n");
                throw $e;
            }
        }


}