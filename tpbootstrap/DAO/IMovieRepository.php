<?php  namespace DAO;

interface IMovieRepository{

    function add(Movie $movie);
    function getAll();
    function saveData();
    function retrieveData();
  
}

?>
