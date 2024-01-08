<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Subject.php';

class SubjectRepository extends Repository
{
    private static $instance;

    
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getAllSubjects(): array
    {
        $stmt = $this->database->connect()->query('
            SELECT * FROM public.subjects
        ');

        $subjects = [];
        while ($subjectData = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $subjects[] = new Subject($subjectData['name']);
        }

        return $subjects;
    }
}