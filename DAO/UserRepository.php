<?php namespace DAO;

use Models\User as User;
use DAO\Connection as Connection;
use DAO\IRepository as IRepository;

     class UserRepository extends Singleton implements Irepository
     {
          private $connection;

          function __construct() {

          }

         

          public function Add($user) {

			$sql = "INSERT INTO Users (firstname, lastname, email, userName, password, permissions, dni) VALUES (:firstname, :lastname, :email, :userName, :password, :permissions, :dni)";

               $parameters['firstname'] = $user->getFirstname();
               $parameters['lastname'] = $user->getLastname();
               $parameters['email'] = $user->getEmail();
               $parameters['userName'] = $user->getUserName();
               $parameters['password'] = $user->getPassword();
               $parameters['permissions'] = 2;
               $parameters['dni'] = $user->getDni();
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


          public function edit($user) {
               $sql = "UPDATE Users 
               SET 
               firstname = :firstname, 
               lastname = :lastname, 
               password = :password 
               WHERE id_user = :id_user";

               $parameters['firstname'] = $user->getFirstname();
               $parameters['lastname'] = $user->getLastname();
               $parameters['password'] = $user->getPassword();   
               $parameters['id_user'] = $user->getId();          
               try {
     			$this->connection = Connection::getInstance();
				return $this->connection->ExecuteNonQuery($sql, $parameters);
			} catch(\PDOException $ex) {
                   throw $ex;
              }
          }

  
          public function delete($email) {
               /*$sql = "DELETE FROM Users WHERE email = :email";

               $obj_pdo = new Conexion();

               try {
                    $conexion = $obj_pdo->conectar();

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
                    $user = new User();
                    $user->setId($p['id_user']);
                    $user->setUserName($p['userName']);
                    $user->setFirstName($p['firstname']);
                    $user->setLastName($p['lastname']);
                    $user->setEmail($p['email']);
                    $user->setPassword($p['password']);
                    $user->setPermissions($p['permissions']);
                    $user->setDni($p['dni']);
                    return $user;
               }, $value);

               return count($resp) > 1 ? $resp : $resp['0'];

		}
     }
