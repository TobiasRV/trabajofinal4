<?php  namespace DAO;

interface IRepository{

    function Add($obj);
    function getAll();
    function read($id);
    function saveData();
    function retrieveData();
  
}

?>
