<?php namespace Models;

class Movie{
    private $adult;
    private $idGenre;
    private $idMovie;
    private $homePage;
    private $language;
    private $title;
    private $overview;
    private $posterPath;
    private $releaseDate;

    public function __construct()
    {
        
    }

    public function getAdult(){
		return $this->adult;
	}

	public function setAdult($adult){
		$this->adult = $adult;
	}

	public function getIdGenre(){
		return $this->idGenre;
	}

	public function setIdGenre($idGenre){
		$this->idGenre = $idGenre;
	}

	public function getIdMovie(){
		return $this->idMovie;
	}

	public function setIdMovie($idMovie){
		$this->idMovie = $idMovie;
	}

	public function getHomePage(){
		return $this->homePage;
	}

	public function setHomePage($homePage){
		$this->homePage = $homePage;
	}

	public function getLanguage(){
		return $this->language;
	}

	public function setLanguage($language){
		$this->language = $language;
	}

	public function getTitle(){
		return $this->title;
	}

	public function setTitle($title){
		$this->title = $title;
	}

	public function getOverview(){
		return $this->overview;
	}

	public function setOverview($overview){
		$this->overview = $overview;
	}

	public function getPosterPath(){
		return $this->posterPath;
	}

	public function setPosterPath($posterPath){
		$this->posterPath = $posterPath;
	}

	public function getReleaseDate(){
		return $this->releaseDate;
	}

	public function setReleaseDate($releaseDate){
		$this->releaseDate = $releaseDate;
	}
}