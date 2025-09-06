<?php

namespace Budgetlance\Dao\Site\Usuario;

use Budgetlance\Dao\Dao;
use Budgetlance\Model\Site\Usuario\ModelUsuario;

class DaoUsuario extends Dao
{
    /**
     * Para criação de usuario:
     */

        public function createUsuario(ModelUsuario $usuario)
        {
            try{
                $sql = "INSERT INTO usuario (nm_usuario, email, senha) VALUES (:nm_usuario, :email, :senha) ";
                // essa é uma string de comando.

                //metodo de preparacao da string para inserção de dados.
                $stmt = Dao::getConnection()->prepare($sql);
                $stmt->bindValue(":nm_usuario", $usuario->getNomeUsuario());
                $stmt->bindValue(":email", $usuario->getEmailUsuario());
                $stmt->bindValue(":senha", $usuario->getSenhaHash());
                $stmt->execute();

                $id = Dao::getConnection()->lastInsertId(); // <- aqui você pega o id do usuário recém-criado
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
                $sql =
                    " SELECT                          " .
                    "   U.ID AS id,                   " .
                    "   U.NM_USUARIO AS nome,         " .
                    "   U.EMAIL AS email,             " .
                    "   U.SENHA AS senha,             " .
                    "   U.TIPO_USUARIO AS tipo_usuario " .
                    " FROM                            " .
                    "   USUARIO U                     " .
                    " WHERE                           " .
                    "  U.EMAIL = :email               ";
            
                $stmt = Dao::getConnection()->prepare($sql);
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
                $data = $stmt->fetch();

                if($data){
                    /**
                     * ele vai retornar os dados da query do banco para a model
                     */
                    return ModelUsuario::fromDatabase($data);
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


}