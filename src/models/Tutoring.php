<?php

class Tutoring
{
    private $id;
    private $subject;
    private $date;
    private $duration;
    private $price;
    private $creator;
    private $description;
    private $participants = [];

    public function __construct($subject, $date, $duration, $price, $creator, $description)
    {
        $this->subject = $subject;
        $this->date = $date;
        $this->duration = $duration;
        $this->price = $price;
        $this->creator = $creator;
        $this->description = $description;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function getDate()
    {
        $dateDateTime = new DateTime($this->date);
        return $dateDateTime->format('Y-m-d H:i');
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getDuration()
    {
        $durationDateTime = new DateTime($this->duration);
        return $durationDateTime->format('H:i');
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getCreator()
    {
        return $this->creator;
    }

    public function setCreator($creator)
    {
        $this->creator = $creator;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function addParticipant($participant)
    {
        $this->participants[] = $participant;
    }

    public function getParticipants()
    {
        return $this->participants;
    }
}
