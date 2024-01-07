<?php

class UserCredentials {
    private $name;
    private $surname;
    private $address;

    public function __construct($name, $surname, $address) {
        $this->name = $name;
        $this->surname = $surname;
        $this->address = $address;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function setSurname($surname) {
        $this->surname = $surname;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }
}