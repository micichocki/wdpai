<?php

class Tutoring {
    private $id;
    private $subjectId; // Updated to represent subject_id
    private $date;
    private $price;
    private $creatorId; // Updated to represent creator_id
    private $description;
    private $participants = []; // Array to store multiple participants

    public function __construct($subjectId, $date, $price, $creatorId, $description) {
        $this->subjectId = $subjectId;
        $this->date = $date;
        $this->price = $price;
        $this->creatorId = $creatorId;
        $this->description = $description;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getSubjectId() {
        return $this->subjectId;
    }

    public function setSubjectId($subjectId) {
        $this->subjectId = $subjectId;
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

    public function getCreatorId() {
        return $this->creatorId;
    }

    public function setCreatorId($creatorId) {
        $this->creatorId = $creatorId;
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
