<?php

namespace Budgetlance\Dao\Site\Usuario;

use Budgetlance\Dao\Connection;
use Budgetlance\Hydrator\Usuario\HydratorUsuario;
use Budgetlance\Model\Site\Usuario\ModelUsuario;

final class DaoUsuario extends Connection
{
    /**
     * Para criação de usuario:
     */

        public function createUsuario(ModelUsuario $usuario): ModelUsuario
        {
            try{
                $sql = "INSERT INTO usuario (nm_usuario, email, senha) VALUES (:nm_usuario, :email, :senha) ";
                // essa é uma string de comando.

                //metodo de preparacao da string para inserção de dados.
                $stmt = Connection::getConnection()->prepare($sql);
                $stmt->bindValue(":nm_usuario", $usuario->getNomeUsuario());
                $stmt->bindValue(":email", $usuario->getEmailUsuario());
                $stmt->bindValue(":senha", $usuario->getSenhaHash());
                $stmt->execute();

                $id = Connection::getConnection()->lastInsertId(); // <- aqui você pega o id do usuário recém-criado
                $usuario->setIdUsuario($id);

                return $usuario;
                
            } catch(\PDOException $e){
                // Código 23000 = violação de UNIQUE (o email é unico e não pode repetido.)
                if ($e->getCode() === '23000') {
                    throw new \Budgetlance\Config\validationException(
                        "Erro no cadastro!",
                        "O email {$usuario->getEmailUsuario()} já está cadastrado."
                    );
                }

                error_log("[" . date("Y-m-d H:i:s") . "] Erro dentro de CreateUsuario: " . $e->getMessage() . "\n");
                throw $e;
            } catch(\Exception $e){
                error_log("[" . date("Y-m-d H:i:s") . "] Erro dentro de CreateUsuario: " . $e->getMessage() . "\n");
                throw $e;
            }
        }
    /**
     * Para verificação de usuario:
     */
        
        public function buscarPorEmail(string $email)
        {
            try{
                $sql = "SELECT * FROM usuario WHERE email = :email";
            
                $stmt = Connection::getConnection()->prepare($sql);
                $stmt->bindValue(":email", $email);
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
                     * ele vai retornar os dados da query do banco para o Hydrator transformar o array associativo em objeto ModelUsuario e retornar isso pra ModelUsuario.
                     */
                    return HydratorUsuario::fromRow($row);
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

        public function buscarPeloId(int $id_usuario): ?ModelUsuario
        {
            try{
                $sql = "SELECT * FROM usuario WHERE id = :id ";

                $stmt = Connection::getConnection()->prepare($sql);
                $stmt->bindValue(":id", $id_usuario);
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
                    return HydratorUsuario::fromRow($row);
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

        public function updateUsuario(ModelUsuario $usuario):void
        {
            try{
                $sql = 'UPDATE usuario SET nm_usuario = :nome, email = :email WHERE id = :id';

                $stmt = Connection::getConnection()->prepare($sql);

                $stmt->bindValue(":nome", $usuario->getNomeUsuario());
                $stmt->bindValue(":email", $usuario->getEmailUsuario());
                $stmt->bindValue(":id", $usuario->getIdUsuario());

                $stmt->execute();

            } catch(\PDOException $e){
                
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de updateUsuario: " . $e->getMessage() . "\n");
                throw $e;
            } catch(\Exception $e){
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de updateUsuario: " . $e->getMessage() . "\n");
                throw $e;
            }
            
        }

        public function deleteUsuario(int $id): void
        {
            try{
                $sql = "DELETE FROM usuario WHERE id = :id";

                $stmt = Connection::getConnection()->prepare($sql);

                $stmt->bindValue(":id", $id);

                $stmt->execute();
            }catch(\PDOException $e){
                
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de deleteUsuario: " . $e->getMessage() . "\n");
                throw $e;
            } catch(\Exception $e){
                error_log("[" . date("Y-m-d H:i:s") . "] Erro de deleteUsuario: " . $e->getMessage() . "\n");
                throw $e;
            }
        }


}