<?php

interface IUserRepository{

    public function create($user);
    public function getAll();
    function saveData();
    function retrieveData();

}