<?php

class User {
    private $id;
    private $email;
    private $password;
    private $userCredentials;

    public function __construct(
        string $email,
        string $password,
        UserCredentials $userCredentials=null,
    ) {
        $this->email = $email;
        $this->password = $password;
        $this->userCredentials = $userCredentials;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getUserCredentials() {
        return $this->userCredentials;
    }

    public function setUserCredentials($userCredentials) {
        $this->userCredentials = $userCredentials;
    }
}