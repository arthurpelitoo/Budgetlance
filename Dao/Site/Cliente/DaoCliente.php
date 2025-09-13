<?php

namespace Budgetlance\Dao\Site\Cliente;

use Budgetlance\Dao\Connection;
use Budgetlance\Hydrator\Cliente\HydratorCliente;
use Budgetlance\Model\Site\Cliente\ModelCliente;

class DaoCliente extends Connection
{

    // evita erro de digitação na hora de puxar a tabela na query.
    private const TABLE = 'cliente';

    /**
     * Para criação de Cliente:
     */

        public function createCliente(ModelCliente $cliente): ModelCliente
        {
            try{
                $sql = "INSERT INTO " . self::TABLE . " (id_usuario, nm_cliente, telefone, email) VALUES (:id_usuario, :nm_cliente, :telefone, :email) ";
                // essa é uma string de comando.

                //metodo de preparacao da string para inserção de dados.
                $stmt = Connection::getConnection()->prepare($sql);

                $stmt->bindValue(":id_usuario", $cliente->getIdUsuario());
                $stmt->bindValue(":nm_cliente", $cliente->getNomeCliente());
                $stmt->bindValue(":telefone", $cliente->getTelefoneCliente());
                $stmt->bindValue(":email", $cliente->getEmailCliente());
                $stmt->execute();

                $id = Connection::getConnection()->lastInsertId(); // <- aqui você pega o id do cliente recém-criado
                $cliente->setIdCliente($id);

                return $cliente;
                
            } catch(\PDOException $e){

                error_log("[" . date("Y-m-d H:i:s") . "] Erro dentro de CreateCliente: " . $e->getMessage() . "\n");
                throw $e;
            } catch(\Exception $e){
                error_log("[" . date("Y-m-d H:i:s") . "] Erro dentro de CreateCliente: " . $e->getMessage() . "\n");
                throw $e;
            }
        }
    /**
     * Para procurar Cliente:
     */

        public function buscarClientes(int $id_usuario): ?array
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
                     * ele vai retornar os dados da query do banco para o Hydrator transformar o array associativo em objeto ModelCliente e retornar isso pra ModelCliente.
                     */
                    return HydratorCliente::fromDatabase($rows);
                }else{
                    return null;
                }
            } catch(\PDOException $e){
                
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de buscarClientes: " . $e->getMessage() . "\n");
                throw $e;
            } catch(\Exception $e){
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de buscarClientes: " . $e->getMessage() . "\n");
                throw $e;
            }
        }

        public function buscarPeloId(int $id_usuario, int $id): ?ModelCliente
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
                    return HydratorCliente::fromRow($row);
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
                $sql = "SELECT * FROM " . self::TABLE . " WHERE id_usuario = :id_usuario AND nm_cliente = :nm_cliente ";
            
                $stmt = Connection::getConnection()->prepare($sql);
                $stmt->bindValue(":id_usuario", $id_usuario);
                $stmt->bindValue(":nm_cliente", $nome);
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
                    return HydratorCliente::fromDatabase($rows);
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
        
        public function buscarPorEmail(int $id_usuario, string $email): ?array
        {
            try{
                $sql = "SELECT * FROM " . self::TABLE . " WHERE id_usuario = :id_usuario AND email = :email ";
            
                $stmt = Connection::getConnection()->prepare($sql);
                $stmt->bindValue(":id_usuario", $id_usuario);
                $stmt->bindValue(":email", $email);
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
                    return HydratorCliente::fromDatabase($rows);
                }else{
                    return null;
                }
            } catch(\PDOException $e){
                
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de buscarPorEmail: " . $e->getMessage() . "\n");
                throw $e;
            } catch(\Exception $e){
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de buscarPorEmail: " . $e->getMessage() . "\n");
                throw $e;
            }
            
        }

        public function buscarPorTelefone(int $id_usuario, string $telefone): ?array
        {
            try{
                $sql = "SELECT * FROM " . self::TABLE . " WHERE id_usuario = :id_usuario AND telefone = :telefone ";
            
                $stmt = Connection::getConnection()->prepare($sql);
                $stmt->bindValue(":id_usuario", $id_usuario);
                $stmt->bindValue(":telefone", $telefone);
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
                    return HydratorCliente::fromDatabase($rows);
                }else{
                    return null;
                }
            } catch(\PDOException $e){
                
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de buscarPorTelefone: " . $e->getMessage() . "\n");
                throw $e;
            } catch(\Exception $e){
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de buscarPorTelefone: " . $e->getMessage() . "\n");
                throw $e;
            }
        }

        public function updateCliente(ModelCliente $cliente):void
        {
            try{
                $sql = "UPDATE " . self::TABLE . " SET nm_cliente = :nome, telefone = :telefone, email = :email WHERE id = :id AND id_usuario = :id_usuario ";

                $stmt = Connection::getConnection()->prepare($sql);

                $stmt->bindValue(":nome", $cliente->getNomeCliente());
                $stmt->bindValue(":telefone", $cliente->getTelefoneCliente());
                $stmt->bindValue(":email", $cliente->getEmailCliente());
                $stmt->bindValue(":id", $cliente->getIdCliente());
                $stmt->bindValue(":id_usuario", $cliente->getIdUsuario());

                $stmt->execute();

            } catch(\PDOException $e){
                
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de updateCliente: " . $e->getMessage() . "\n");
                throw $e;
            } catch(\Exception $e){
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de updateCliente: " . $e->getMessage() . "\n");
                throw $e;
            }
            
        }

        public function deleteCliente(int $id, int $id_usuario): void
        {
            try{
                $sql = "DELETE FROM " . self::TABLE . " WHERE id = :id AND id_usuario = :id_usuario";

                $stmt = Connection::getConnection()->prepare($sql);

                $stmt->bindValue(":id", $id);
                $stmt->bindValue(":id_usuario", $id_usuario);

                $stmt->execute();
            }catch(\PDOException $e){
                
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de deleteCliente: " . $e->getMessage() . "\n");
                throw $e;
            } catch(\Exception $e){
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de deleteCliente: " . $e->getMessage() . "\n");
                throw $e;
            }
        }


}