<?php

require_once 'User.php';
require_once 'Tutoring.php';

class Tutor extends User {
    protected $subjects;

    public function __construct($id, $username, $email, $password, $subjects) {
        parent::__construct($id, $username, $email, $password);
        $this->subjects = $subjects;
    }

    public function createTutoring($student, $date, $duration) {
        $tutoring = new Tutoring($this, $student, $date, $duration);
        return $tutoring;
    }
}