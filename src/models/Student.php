<?php
require_once 'User.php';

class Student extends User {
protected $courses;

public function __construct($id, $username, $email, $password, $courses) {
parent::__construct($id, $username, $email, $password);
$this->courses = $courses;
}

}