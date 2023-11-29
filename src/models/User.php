<?php

class User
{
    private $email;
    private $password;
    private $name;
    private $surname;
    private $creation_date;

    public function __construct(
        string $email,
        string $password,
        string $name,
        string $surname
    ) {
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->surname = $surname;
        $this->creation_date = new DateTime();
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getCreationDate(): DateTime
    {
        return $this->creation_date;
    }
}
