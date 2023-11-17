<?php

class Tutoring
{
    protected $tutor;
    protected $student;
    protected $date;
    protected $duration;

    public function __construct($tutor, $student, $date, $duration)
    {
        $this->tutor = $tutor;
        $this->student = $student;
        $this->date = $date;
        $this->duration = $duration;
    }
}
