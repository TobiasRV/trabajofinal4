<?php

namespace DAOJson;

use Models\User as User;
use DAOJson\IRepository as IRepository;

class UserRepository implements IRepository
{
    private $userList = array();

    public function __constructor()
    { }

    public function Add($user)
    {


        $this->retrieveData();

        if (empty($this->userList)) {
            $newId = 1;
        } else {
            $lastElement = end($this->userList);
            $newId = $lastElement->getId() + 1;
        }
        $user->setId($newId);

        array_push($this->userList, $user);

        $this->saveData();
    }

    public function read($email)
    {
        $this->retrieveData();
        $flag = false;
        $userReturn = new User();
        foreach ($this->userList as $u) {
            if (!$flag) {
                if ($email == $u->getEmail()) {
                    $flag = true;
                    $userReturn = $u;
                }
            }
        }
        return $userReturn;
    }

    public function getAll()
    {

        $this->retrieveData();

        return $this->userList;
    }

    public function saveData()
    {

        $arrayToJson = array();

        foreach ($this->userList as $user) {

            $valuesArray["id"] = $user->getId();
            $valuesArray["userName"] = $user->getUserName();
            $valuesArray["password"] = $user->getPassword();
            $valuesArray["email"] = $user->getEmail();
            $valuesArray["firstname"] = $user->getFirstname();
            $valuesArray["lastname"] = $user->getLastname();
            $valuesArray["permissions"] = $user->getPermissions();
            $valuesArray["tickets"] = $user->getTickets();
            $valuesArray["dni"] = $user->getDni();
            $valuesArray["creditCards"] = $user->getCreditCards();


            array_push($arrayToJson, $valuesArray);
        }

        $jsonContent = json_encode($arrayToJson, JSON_PRETTY_PRINT);

        file_put_contents('Data/users.json', $jsonContent);
    }


    public function retrieveData()
    {

        $this->userList = array();

        if (file_exists('Data/users.json')) {

            $jsonContent = file_get_contents('Data/users.json');

            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToDecode as $valuesArray) {

                $user = new User();

                $user->setId($valuesArray["id"]);
                $user->setUserName($valuesArray["userName"]);
                $user->setPassword($valuesArray["password"]);
                $user->setEmail($valuesArray["email"]);
                $user->setFirstname($valuesArray["firstname"]);
                $user->setLastname($valuesArray["lastname"]);
                $user->setPermissions($valuesArray["permissions"]);
                $user->setTickets($valuesArray["tickets"]);
                $user->setDni($valuesArray["dni"]);
                $user->setCreditCards($valuesArray["creditCards"]);

                array_push($this->userList, $user);
            }
        }
    }

    public function edit($user)
    {

        $this->retrieveData();
        $flag = false;
        $i = 0;
        foreach ($this->userList as $values) {

            if ($user->getEmail() == $values->getEmail()) {
                $values->setFirstname($user->getFirstname());
                $values->setLastname($user->getLastname());
                $values->setPassword($user->getPassword());
                break;
            }
        }


        $this->saveData();
    }


    public function userExists($username)
    {
        $flag = false;
        while ($flag == false && $i < count($userList)) {
            if ($userName == $userList->userNameAt($i)) {
                $flag = true;
            }
            $i++;
        }
        return $flag;
    }

    public function searchUser($userName)
    {
        $this->userList = $this->getAll();
        $flag = false;
        $i = 0;
        while ($flag == false && $i < count($this->userList)) {
            if ($userName == $this->userNameAt($i)) {
                $flag = true;
                return $this->getUserAt($i);
            }
            $i++;
        }
    }
}
