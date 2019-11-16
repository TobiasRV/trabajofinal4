<?php

namespace DAO;

use Models\Ticket as Ticket;

class TicketRepository extends Singleton
{

    private $connection;

          function __construct() {

          }
          public function Add($ticket) {

			$sql = "INSERT INTO Tickets (id_purchase) VALUES (:id_purchase)";

               $parameters['id_purchase'] = $ticket->getIdPurchase();

               try {
     			$this->connection = Connection::getInstance();
				return $this->connection->ExecuteNonQuery($sql, $parameters);
			} catch(\PDOException $ex) {
                   throw $ex;
              }
          }

          public function read($id) {

               $sql = "SELECT * FROM Tickets where id_ticket = :id_ticket";

               $parameters['id_ticket'] = $id;

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
               $sql = "SELECT * FROM Tickets";

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


          public function edit($ticket) {


            
               $sql = "UPDATE Tickets SET id_purchase = :id_purchase WHERE id_ticket = :id_ticket";

               $parameters['id_purchase'] = $ticket->getIdPurchase();

               try {
     			$this->connection = Connection::getInstance();
				return $this->connection->ExecuteNonQuery($sql, $parameters);
			} catch(\PDOException $ex) {
                   throw $ex;
              }
          }

  
              
          public function delete($id) 
          {
              //en ningun momento nos piden reembolsos asi que queda asi por ahora
              
          }

		protected function mapear($value) {

			$value = is_array($value) ? $value : [];

			$resp = array_map(function($p){              
                     
                    $ticket = new Ticket();
                    $ticket->setIdTicket($p['id_ticket']);
                    $ticket->setIdPurchase($p['id_purchase']);
                    return $ticket;
               }, $value);

               return count($resp) > 1 ? $resp : $resp['0'];

        }
}