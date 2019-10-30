<?php

namespace Models;

class Movie
{
	private $adult;
	private $idGenre = array();
	private $idMovie;
	private $title;
	private $originalTitle;
	private $overview;
	private $posterPath;
	private $releaseDate;
	private $backdropPath;

	public function __construct()
	{ }

	public function getOriginalTitle()
	{
		return $this->originalTitle;
	}

	public function setOriginalTitle($originalTitle)
	{
		$this->originalTitle = $originalTitle;
	}
	public function getBackdropPath()
	{
		return $this->backdropPath;
	}

	public function setBackdropPath($backdropPath)
	{
		$this->backdropPath = $backdropPath;
	}

	public function getAdult()
	{
		return $this->adult;
	}

	public function setAdult($adult)
	{
		$this->adult = $adult;
	}

	public function getIdGenre()
	{
		return $this->idGenre;
	}

	public function setIdGenre($idGenre)
	{
		$this->idGenre = $idGenre;
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

	public function getOverview()
	{
		return $this->overview;
	}

	public function setOverview($overview)
	{
		$this->overview = $overview;
	}

	public function getPosterPath()
	{
		return $this->posterPath;
	}

	public function setPosterPath($posterPath)
	{
		$this->posterPath = $posterPath;
	}

	public function getReleaseDate()
	{
		return $this->releaseDate;
	}

	public function setReleaseDate($releaseDate)
	{
		$this->releaseDate = $releaseDate;
	}
}
