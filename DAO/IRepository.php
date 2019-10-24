<?php  namespace DAO;

interface IRepository{

    function Add(Movie $movie);
    function getAll();
    function saveData();
    function retrieveData();
  
}

?>
