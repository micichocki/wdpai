<?php

class UserCredentials
{
    private $name;
    private $surname;
    private $address;
    private $dateOfJoin; 


    public function __construct($name, $surname, $address)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->address = $address;
        $this->dateOfJoin = new DateTime(); // Default to current timestamp if $dateOfJoin is not provided
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

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }
    public function getDateOfJoin()
    {
        return $this->dateOfJoin;
    }

}
