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
               $sql = "SELECT * FROM CreditCards";

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
                    $creditCard->setId($p['id_creditcard']);
                    $creditCard->setCompany($p['company']);
                    $creditCard->setNumber($p['number']);
                    $creditCard->setIdUser($p['id_user']);
                    return $creditCard;
               }, $value);

               return count($resp) > 1 ? $resp : $resp['0'];

        }

        //funciones extras

        public function getCreditCards($id_user)
        {
             $repo = new CreditCardRepository();
             $repo = $this->getAll();
             $creditCards = array ();
             foreach($repo as $cc)
             {
                  if($cc->getIdUser() == $id_user)
                  {
                       array_push($creditCards, $cc);
                  }
             }
             return $creditCards;
        }

        public function getCompany($id_creditcard)
        {
          return $this->read($id_creditcard)->getCompany();
        }

        public function getId($creditCard)
        {
          $repo = new CreditCardRepository();
          $repo = $this->getAll();
          foreach($repo as $cc)
          {
               if($cc->getNumber() == $creditCard->getNumber())
               {
                    $creditCard->setId($cc->getId());
               }
          }

          return $creditCard;
        }
}