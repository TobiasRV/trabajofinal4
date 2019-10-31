<?php namespace DAO;

use Models\User as User;
use DAO\Connection as Connection;

     /**
      *
      */
     class User 
     {
          private $connection;

          function __construct() {}

          /**
           *
           */
          public function Add($user) {

               // Guardo como string la consulta sql utilizando como values, marcadores de parámetros con nombre (:name) o signos de interrogación (?) por los cuales los valores reales serán sustituidos cuando la sentencia sea ejecutada
			$sql = "INSERT INTO users (firstname, lastname, email, username, password, permissions) VALUES (:firstname, :lastname, :email, :username, :password, :permissions)";

               $parameters['fistname'] = $user->getFirstname();
               $parameters['lastname'] = $user->getLastname();
               $parameters['email'] = $user->getEmail();
               $parameters['username'] = $user->getUserName();
               $parameters['password'] = $user->getPassword();
               $parameters['permissions'] = $user->getPermissions();

               try {
                    // creo la instancia connection
     			$this->connection = Connection::getInstance();
				// Ejecuto la sentencia.
				return $this->connection->ExecuteNonQuery($sql, $parameters);
			} catch(\PDOException $ex) {
                   throw $ex;
              }
          }


          /**
           *
           */
          public function read($_email) {

               $sql = "SELECT * FROM users where email = :email";

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

          /**
           *
           */
          public function getAll() {
               $sql = "SELECT * FROM users";

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


          /**
           *
           */
          public function edit($_user) {
               $sql = "UPDATE users SET name = :name, surname = :surname, nationality = :nationality, state = :state, city = :city, birthdate = :birthdate, email = :email, password = :password, avatar = :avatar, role = :role";

               $parameters['name'] = $_user->getName();
               $parameters['surname'] = $_user->getSurname();
               $parameters['nationality'] = $_user->getNationality();
               $parameters['state'] = $_user->getState();
               $parameters['city'] = $_user->getCity();
               $parameters['birthdate'] = $_user->getBirthdate();
               $parameters['email'] = $_user->getEmail();
               $parameters['pass'] = $_user->getPass();
               $parameters['avatar'] = $_user->getAvatar()['avatar']['name'];
               $parameters['role'] = $_user->getRole();

               try {
                    // creo la instancia connection
     			$this->connection = Connection::getInstance();
				// Ejecuto la sentencia.
				return $this->connection->ExecuteNonQuery($sql, $parameters);
			} catch(\PDOException $ex) {
                   throw $ex;
              }
          }

          /**
           *
           */
          public function update($value) {

          }
          /**
           *
           */
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

          /**
		* Transforma el listado de usuario en
		* objetos de la clase Usuario
		*
		* @param  Array $gente Listado de personas a transformar
		*/
		protected function mapear($value) {

			$value = is_array($value) ? $value : [];

			$resp = array_map(function($p){
				return new M_Usuario($p['id'], $p['name'], $p['surname'], $p['birthdate'], $p['nationality'], $p['state'], $p['city'], $p['email'], $p['password'], $p['avatar'], $p['role']);
			}, $value);

               return count($resp) > 1 ? $resp : $resp['0'];

		}
     }
