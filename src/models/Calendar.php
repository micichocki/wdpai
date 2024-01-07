<?php

class Calendar {
    private $user;
    private $tutorings = [];

    public function __construct($user) {
        $this->user = $user;
    }

    public function getUser() {
        return $this->user;
    }

    public function addUserTutoring($tutoring) {
        $this->tutorings[] = $tutoring;
    }

    public function getTutorings() {
        return $this->tutorings;
    }
}