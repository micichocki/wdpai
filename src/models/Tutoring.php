<?php

class Tutoring {
    private $subject;
    private $date;
    private $price;
    private $participant;
    private $creator;
    private $description;

    public function __construct($subject, $date, $price, $participant, $creator, $description) {
        $this->subject = $subject;
        $this->date = $date;
        $this->price = $price;
        $this->participant = $participant;
        $this->creator = $creator;
        $this->description = $description;
    }

    public function getSubject() {
        return $this->subject;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getParticipant() {
        return $this->participant;
    }

    public function setParticipant($participant) {
        $this->participant = $participant;
    }

    public function getCreator() {
        return $this->creator;
    }

    public function setCreator($creator) {
        $this->creator = $creator;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
}

