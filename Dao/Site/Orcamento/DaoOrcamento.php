<?php

namespace Budgetlance\Dao\Site\Orcamento;

use Budgetlance\Dao\Connection;
use Budgetlance\Hydrator\Orcamento\HydratorOrcamento;
use Budgetlance\Model\Site\Orcamento\ModelOrcamento;
use PDO;

final class DaoOrcamento extends Connection
{

    // evita erro de digitação na hora de puxar a tabela na query.
    private const TABLE = 'orcamento';

    /**
     * Para criação de Cliente:
     */

        public function createOrcamento(ModelOrcamento $orcamento): ModelOrcamento
        {
            try{
                $sql = "INSERT INTO " . self::TABLE . " (id_cliente, id_usuario, id_cs, nm_orcamento, desc_orcamento, valor, prazo, status) VALUES (:id_cliente, :id_usuario, :id_cs, :nm_orcamento, :desc_orcamento, :valor, :prazo, :status) ";
                // essa é uma string de comando.

                //metodo de preparacao da string para inserção de dados.
                $stmt = Connection::getConnection()->prepare($sql);

                $stmt->bindValue(":id_cliente", $orcamento->getIdCliente());
                $stmt->bindValue(":id_usuario", $orcamento->getIdUsuario());
                $stmt->bindValue(":id_cs", $orcamento->getIdCategoriaServico());
                $stmt->bindValue(":nm_orcamento", $orcamento->getNomeOrcamento());
                $stmt->bindValue(":desc_orcamento", $orcamento->getDescricaoOrcamento());
                $stmt->bindValue(":valor", $orcamento->getValorOrcamento(), PDO::PARAM_STR);
                $stmt->bindValue(":prazo", $orcamento->getPrazoOrcamento()->format('Y-m-d H:i:s'), PDO::PARAM_STR);
                $stmt->bindValue(":status", $orcamento->getStatusOrcamento());
                $stmt->execute();

                $id = Connection::getConnection()->lastInsertId(); // <- aqui você pega o id do cliente recém-criado
                $orcamento->setIdOrcamento($id);

                return $orcamento;
                
            } catch(\PDOException $e){

                error_log("[" . date("Y-m-d H:i:s") . "] Erro dentro de CreateOrcamento: " . $e->getMessage() . "\n");
                throw $e;
            } catch(\Exception $e){
                error_log("[" . date("Y-m-d H:i:s") . "] Erro dentro de CreateOrcamento: " . $e->getMessage() . "\n");
                throw $e;
            }
        }
    /**
     * Para procurar Orcamento:
     */

        public function buscarOrcamento(int $id_usuario): ?array
        {
            try{

                $sql = <<<SQL

                        SELECT                             
                        o.id,                             
                        o.id_cliente,                    
                        o.id_usuario,                    
                        o.id_cs,                         
                        o.nm_orcamento,                  
                        o.desc_orcamento,                
                        o.valor,                         
                        o.prazo,                         
                        o.status,                        
                        c.nm_cliente,                    
                        s.nm_servico                     
                        FROM                               
                        orcamento o                      
                        JOIN cliente c ON                  
                        o.id_cliente = c.id              
                        JOIN categoria_servico s ON        
                        o.id_cs = s.id                   
                        WHERE o.id_usuario = :id_usuario

                        SQL;
            
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
                     * ele vai retornar os dados da query do banco para o Hydrator transformar o array associativo em objeto ModelCliente e retornar isso pra ModelCliente.
                     */
                    return HydratorOrcamento::fromDatabase($rows);
                }else{
                    return null;
                }
            } catch(\PDOException $e){
                
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de buscarOrcamentos: " . $e->getMessage() . "\n");
                throw $e;
            } catch(\Exception $e){
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de buscarOrcamentos: " . $e->getMessage() . "\n");
                throw $e;
            }
        }

        //pra realizar a recuperação de Dados para update
        public function buscarPeloId(int $id_usuario, int $id): ?ModelOrcamento
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
                     * ele vai retornar os dados da query do banco para o Hydrator transformar o array associativo em objeto ModelCliente e retornar isso pra ModelCliente.
                     */
                    return HydratorOrcamento::fromRow($row);
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
                $sql = "SELECT * FROM " . self::TABLE . " WHERE id_usuario = :id_usuario AND nm_orcamento = :nm_orcamento ";
            
                $stmt = Connection::getConnection()->prepare($sql);
                $stmt->bindValue(":id_usuario", $id_usuario);
                $stmt->bindValue(":nm_orcamento", $nome);
                $stmt->execute();

                /**
                 * O fetchAll() envia um array de array associativos,
                 * enviando varios registros, bom nesse caso, onde queremos os resultados especificos.
                 */
                $rows = $stmt->fetchAll();

                if($rows){
                    /**
                     * ele vai retornar os dados da query do banco para o Hydrator transformar o array associativo em objeto ModelCliente e retornar isso pra ModelCliente.
                     */
                    return HydratorOrcamento::fromDatabase($rows);
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
        
        public function buscarPorDescricao(int $id_usuario, string $descricao): ?array
        {
            try{
                $sql = "SELECT * FROM " . self::TABLE . " WHERE id_usuario = :id_usuario AND desc_orcamento = :desc_orcamento ";
            
                $stmt = Connection::getConnection()->prepare($sql);
                $stmt->bindValue(":id_usuario", $id_usuario);
                $stmt->bindValue(":desc_orcamento", $descricao);
                $stmt->execute();

                /**
                 * O fetchAll() envia um array de array associativos,
                 * enviando varios registros, bom nesse caso, onde queremos os resultados especificos.
                 */
                $rows = $stmt->fetchAll();

                if($rows){
                    /**
                     * ele vai retornar os dados da query do banco para o Hydrator transformar o array associativo em objeto ModelCliente e retornar isso pra ModelCliente.
                     */
                    return HydratorOrcamento::fromDatabase($rows);
                }else{
                    return null;
                }
            } catch(\PDOException $e){
                
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de buscarPorDescricao: " . $e->getMessage() . "\n");
                throw $e;
            } catch(\Exception $e){
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de buscarPorDescricao: " . $e->getMessage() . "\n");
                throw $e;
            }
            
        }

        public function buscarPorValor(int $id_usuario, string $valor): ?array
        {
            try{
                $sql = "SELECT * FROM " . self::TABLE . " WHERE id_usuario = :id_usuario AND valor = :valor ";
            
                $stmt = Connection::getConnection()->prepare($sql);
                $stmt->bindValue(":id_usuario", $id_usuario);
                $stmt->bindValue(":valor", $valor);
                $stmt->execute();

                /**
                 * O fetchAll() envia um array de array associativos,
                 * enviando varios registros, bom nesse caso, onde queremos os resultados especificos.
                 */
                $rows = $stmt->fetchAll();

                if($rows){
                    /**
                     * ele vai retornar os dados da query do banco para o Hydrator transformar o array associativo em objeto ModelCliente e retornar isso pra ModelCliente.
                     */
                    return HydratorOrcamento::fromDatabase($rows);
                }else{
                    return null;
                }
            } catch(\PDOException $e){
                
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de buscarPorValor: " . $e->getMessage() . "\n");
                throw $e;
            } catch(\Exception $e){
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de buscarPorValor: " . $e->getMessage() . "\n");
                throw $e;
            }
        }

        public function updateOrcamento(ModelOrcamento $orcamento):void
        {
            try{
                $sql = "UPDATE " . self::TABLE . " SET id_cliente = :id_cliente, id_usuario = :id_usuario, id_cs = :id_cs, nm_orcamento = :nm_orcamento, desc_orcamento = :desc_orcamento, valor = :valor, prazo = :prazo, status = :status WHERE id = :id AND id_usuario = :id_usuario2 ";

                $stmt = Connection::getConnection()->prepare($sql);

                $stmt->bindValue(":id_cliente", $orcamento->getIdCliente());
                $stmt->bindValue(":id_usuario", $orcamento->getIdUsuario());
                $stmt->bindValue(":id_cs", $orcamento->getIdCategoriaServico());
                $stmt->bindValue(":nm_orcamento", $orcamento->getNomeOrcamento());
                $stmt->bindValue(":desc_orcamento", $orcamento->getDescricaoOrcamento());
                $stmt->bindValue(":valor", $orcamento->getValorOrcamento(), PDO::PARAM_STR);
                $stmt->bindValue(":prazo", $orcamento->getPrazoOrcamento()->format('Y-m-d H:i:s'), PDO::PARAM_STR);
                $stmt->bindValue(":status", $orcamento->getStatusOrcamento());
                $stmt->bindValue(":id", $orcamento->getIdOrcamento());
                $stmt->bindValue(":id_usuario2", $orcamento->getIdUsuario());
                $stmt->execute();

            } catch(\PDOException $e){
                
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de updateOrcamento: " . $e->getMessage() . "\n");
                throw $e;
            } catch(\Exception $e){
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de updateOrcamento: " . $e->getMessage() . "\n");
                throw $e;
            }
            
        }

        public function deleteOrcamento(int $id, int $id_usuario): void
        {
            try{
                $sql = "DELETE FROM " . self::TABLE . " WHERE id = :id AND id_usuario = :id_usuario";

                $stmt = Connection::getConnection()->prepare($sql);

                $stmt->bindValue(":id", $id);
                $stmt->bindValue(":id_usuario", $id_usuario);

                $stmt->execute();
            }catch(\PDOException $e){
                
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de deleteOrcamento: " . $e->getMessage() . "\n");
                throw $e;
            } catch(\Exception $e){
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de deleteOrcamento: " . $e->getMessage() . "\n");
                throw $e;
            }
        }


}