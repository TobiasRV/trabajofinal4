<?php namespace DAO;

use Models\User as User;
use DAO\Connection as Connection;


     class User extends Singleton
     {
          private $connection;

          function __construct() {

          }

          public function Add($user) {

			$sql = "INSERT INTO Users (firstname, lastname, email, username, password, permissions) VALUES (:firstname, :lastname, :email, :username, :password, :permissions)";

               $parameters['fistname'] = $user->getFirstname();
               $parameters['lastname'] = $user->getLastname();
               $parameters['email'] = $user->getEmail();
               $parameters['username'] = $user->getUserName();
               $parameters['password'] = $user->getPassword();
               $parameters['permissions'] = $user->getPermissions();

               try {
     			$this->connection = Connection::getInstance();
				return $this->connection->ExecuteNonQuery($sql, $parameters);
			} catch(\PDOException $ex) {
                   throw $ex;
              }
          }

          public function read($_email) {

               $sql = "SELECT * FROM Users where email = :email";

               $parameters['email'] = $_email;

               try {
                    $this->connection = Connection::getInstance();
                    $resultSet = $this->connection->execute($sql, $parameters);
               } catch(Exception $ex) {
                   throw $ex;
               }


               if(!empty($resultSet))
                    return $this->mapear($resultSet);
               else
                    return false;
          }


          public function getAll() {
               $sql = "SELECT * FROM Users";

               try {
                    $this->connection = Connection::getInstance();
                    $resultSet = $this->connection->execute($sql);
               } catch(Exception $ex) {
                   throw $ex;
               }

               if(!empty($resultSet))
                    return $this->mapear($resultSet);
               else
                    return false;
          }


          public function edit($_user) {
               $sql = "UPDATE users SET firstname = :firstname, lastname = :lastname, email = :email, username = :username, city = :city, birthdate = :birthdate, email = :email, password = :password";

               $parameters['fistname'] = $user->getFirstname();
               $parameters['lastname'] = $user->getLastname();
               $parameters['email'] = $user->getEmail();
               $parameters['username'] = $user->getUserName();
               $parameters['password'] = $user->getPassword();
               $parameters['permissions'] = $user->getPermissions();

               try {
     			$this->connection = Connection::getInstance();
				return $this->connection->ExecuteNonQuery($sql, $parameters);
			} catch(\PDOException $ex) {
                   throw $ex;
              }
          }

  
          public function delete($email) {
               /*$sql = "DELETE FROM usuarios WHERE email = :email";

               $obj_pdo = new Conexion();

               try {
                    $conexion = $obj_pdo->conectar();

				// Creo una sentencia llamando a prepare. Esto devuelve un objeto statement
				$sentencia = $conexion->prepare($sql);

                    $sentencia->bindParam(":email", $email);

                    $sentencia->execute();


               } catch(PDOException $Exception) {

				throw new MyDatabaseException( $Exception->getMessage( ) , $Exception->getCode( ) );

			}*/
          }


		protected function mapear($value) {

			$value = is_array($value) ? $value : [];

			$resp = array_map(function($p){
				return new M_Usuario($p['id'], $p['name'], $p['surname'], $p['birthdate'], $p['nationality'], $p['state'], $p['city'], $p['email'], $p['password'], $p['avatar'], $p['role']);
			}, $value);

               return count($resp) > 1 ? $resp : $resp['0'];

		}
     }
