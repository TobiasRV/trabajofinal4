<?php

namespace DAO;

use Models\Purchase as Purchase;

class PurchaseRepository extends Singleton
{

    private $connection;

          function __construct() {

          }
          public function Add($purchase) {

			$sql = "INSERT INTO Purchases (purchase_day,quantity_tickets,total,discount,id_show, id_creditcard) VALUES (:purchase_day,:quantity_tickets,:total,:discount,:id_show, :id_creditcard)";

               $parameters['purchase_day'] = $purchase->getPurchaseDate();
               $parameters['quantity_tickets'] = $purchase->getQuantityTickets();
               $parameters['total'] = $purchase->getTotal();
               $parameters['discount'] = $purchase->getDiscount();
               $parameters['id_show'] = $purchase->getIdShow();
               $parameters['id_creditcard'] = $purchase->getIdCreditCard();


               try {
     			$this->connection = Connection::getInstance();
				return $this->connection->ExecuteNonQuery($sql, $parameters);
			} catch(\PDOException $ex) {
                   throw $ex;
              }
          }

          public function read($id) {

               $sql = "SELECT * FROM Purchases where id_purchase = :id_purchase";

               $parameters['id_purchase'] = $id;

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
               $sql = "SELECT * FROM Purchases";

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


          public function edit($purchase) {

            //se supone que no podes editar una compra
          }

  
              
              public function delete($name) {
               //No nos pidieron reembolsos asi que queda asi por ahora
                }


		protected function mapear($value) {

			$value = is_array($value) ? $value : [];

			$resp = array_map(function($p){              
                     
                    $purchase = new Purchase();
                    $purchase->setIdPurchase($p['id_purchase']);
                    $purchase->setPurchaseDate($p['purchase_day']);
                    $purchase->setQuantityTickets($p['quantity_tickets']);
                    $purchase->setTotal($p['total']);
                    $purchase->setDiscount($p['discount']);
                    $purchase->setIdShow($p['id_show']);
                    $purchase->setIdCreditCard($p['id_creditcard']);
                    return $purchase;
               }, $value);

               return count($resp) > 1 ? $resp : $resp['0'];

        }

        public function getLastPurchase()
        {
             $sql = "SELECT * FROM Purchases  ORDER BY id_purchase DESC LIMIT 1";
          
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
}