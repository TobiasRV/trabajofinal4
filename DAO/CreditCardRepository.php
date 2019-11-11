<?php

namespace DAO;

use Models\CreditCard as CreditCard;

class CreditCardRepository extends Singleton
{

    private $connection;

          function __construct() {

          }
          public function Add($creditCard) {

			$sql = "INSERT INTO CreditCards (company, number, id_user) VALUES (:company, :number, :id_user)";

               $parameters['company'] = $creditCard->getCompany();
               $parameters['number'] = $creditCard->getNumber();
               $parameters['id_user'] = $creditCard->getIdUser();

               try {
     			$this->connection = Connection::getInstance();
				return $this->connection->ExecuteNonQuery($sql, $parameters);
			} catch(\PDOException $ex) {
                   throw $ex;
              }
          }

          public function read($id) {

               $sql = "SELECT * FROM CreditCards where id_creditcard = :id_creditcard";

               $parameters['id_creditcard'] = $id;

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
               $sql = "SELECT * FROM CreditCard";

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


          public function edit($creditCard) {


            
               $sql = "UPDATE CreditCard SET company = :company, number = :number WHERE id_creditcard = :id_creditcard";

               $parameters['company'] = $creditCard->getCompany();
               $parameters['number'] = $creditCard->getNumber();
               $parameters['id_creditcard'] = $creditCard->getId();

               try {
     			$this->connection = Connection::getInstance();
				return $this->connection->ExecuteNonQuery($sql, $parameters);
			} catch(\PDOException $ex) {
                   throw $ex;
              }
          }

  
              
              public function delete($name) {
            //    $sql = "UPDATE  CreditCard SET status=:status WHERE name = :name";
               
            //    $parameters['status'] = false;
            //    $parameters['name'] = $name;
           
            //    try {
            //        $this->connection = Connection::getInstance();
            //       return $this->connection->ExecuteNonQuery($sql, $parameters);
            //   } catch(\PDOException $ex) {
            //          throw $ex;
            //     }
                }


		protected function mapear($value) {

			$value = is_array($value) ? $value : [];

			$resp = array_map(function($p){              
                     
                    $creditCard = new CreditCard();
                    $creditCard->setId($p['id_creditCard']);
                    $creditCard->setCompany($p['company']);
                    $creditCard->setNumber($p['number']);
                    $creditCard->setIdUser($p['id_user']);
                    return $creditCard;
               }, $value);

               return count($resp) > 1 ? $resp : $resp['0'];

        }
}