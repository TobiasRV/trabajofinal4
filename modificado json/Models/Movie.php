<?php

namespace Models;

class Movie
{
	private $idMovie;
	private $title;
	private $originalTitle;
	private $adult;
	private $overview;
	private $releaseDate;
	private $posterPath;
	private $backdropPath;
	private $idGenre = array();

	public function __construc($idMovie = null,$title = null,$originalTitle = null,$adult = null,$overview = null,$releaseDate = null,$posterPath = null,$backdropPath = null)
	{ 
		$this->idMovie = $idMovie;
		$this->title = $title;
		$this->originalTitle = $originalTitle;
		$this->adult = $adult;
		$this->overview = $overview;
		$this->releaseDate = $releaseDate;
		$this->posterPath = $posterPath;
		$this->backdropPath = $backdropPath;
	}

	public function getIdMovie()
	{
		return $this->idMovie;
	}

	public function setIdMovie($idMovie)
	{
		$this->idMovie = $idMovie;
	}


	public function getTitle()
	{
		return $this->title;
	}

	public function setTitle($title)
	{
		$this->title = $title;
	}

	public function getOriginalTitle()
	{
		return $this->originalTitle;
	}

	public function setOriginalTitle($originalTitle)
	{
		$this->originalTitle = $originalTitle;
	}


	public function getAdult()
	{
		return $this->adult;
	}

	public function setAdult($adult)
	{
		$this->adult = $adult;
	}


	public function getOverview()
	{
		return $this->overview;
	}

	public function setOverview($overview)
	{
		$this->overview = $overview;
	}

	public function getReleaseDate()
	{
		return $this->releaseDate;
	}

	public function setReleaseDate($releaseDate)
	{
		$this->releaseDate = $releaseDate;
	}

	
	public function getPosterPath()
	{
		return $this->posterPath;
	}

	public function setPosterPath($posterPath)
	{
		$this->posterPath = $posterPath;
	}

	public function getBackdropPath()
	{
		return $this->backdropPath;
	}

	public function setBackdropPath($backdropPath)
	{
		$this->backdropPath = $backdropPath;
	}


	public function getIdGenre()
	{
		return $this->idGenre;
	}

	public function setIdGenre($idGenre)
	{
		$this->idGenre = $idGenre;
	}

}
