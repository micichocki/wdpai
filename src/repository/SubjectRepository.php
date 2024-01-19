<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Subject.php';

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

    public function getSubjectNameById(int $subjectId): ?string
    {
        $stmt = $this->database->connect()->prepare('
            SELECT name FROM subjects
            WHERE subject_id = :subject_id
        ');

        $stmt->bindParam(':subject_id', $subjectId, PDO::PARAM_INT);
        $stmt->execute();

        $subjectData = $stmt->fetch(PDO::FETCH_ASSOC);

        return $subjectData ? $subjectData['name'] : null;
    }

    public function getSubjectById(int $subjectId): ?Subject
    {
        $stmt = $this->database->connect()->prepare('
        SELECT name FROM subjects
        WHERE subject_id = :subject_id
    ');

        $stmt->bindParam(':subject_id', $subjectId, PDO::PARAM_INT);
        $stmt->execute();

        $subjectData = $stmt->fetch(PDO::FETCH_ASSOC);

        return $subjectData ? new Subject($subjectData['name']) : null;
    }

    public function getSubjectIdByName(string $subjectName): ?int
    {
        $stmt = $this->database->connect()->prepare('
        SELECT subject_id FROM subjects
        WHERE name = :subject_name
    ');

        $stmt->bindParam(':subject_name', $subjectName, PDO::PARAM_STR);
        $stmt->execute();

        $subjectData = $stmt->fetch(PDO::FETCH_ASSOC);

        return $subjectData ? (int)$subjectData['subject_id'] : null;
    }
}
