<?php

class UserCredentials
{
    private $name;
    private $surname;
    private $city;
    private $dateOfJoin; 


    public function __construct($name, $surname, $city)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->city = $city;
        $this->dateOfJoin = new DateTime();
    }


    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }
    public function getDateOfJoin()
    {
        return $this->dateOfJoin->format('Y-m-d');
    }

}
