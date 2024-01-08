<?php

class Tutoring {
    private $id;
    private $subject;
    private $date;
    private $price;
    private $creator;
    private $description;
    private $participants = []; // Array to store multiple participants

    public function __construct($subject, $date, $price, $creator, $description) {
        $this->subject = $subject;
        $this->date = $date;
        $this->price = $price;
        $this->creator = $creator;
        $this->description = $description;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
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

    public function addParticipant($participant) {
        $this->participants[] = $participant;
    }

    public function getParticipants() {
        return $this->participants;
    }
}