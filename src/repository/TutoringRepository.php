<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Tutoring.php';
require_once __DIR__ . '/../models/User.php';

class TutoringRepository extends Repository
{
    private static $instance;
    private $subjectRepository;
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->subjectRepository = SubjectRepository::getInstance();
        $this->userRepository = UserRepository::getInstance();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getTutoringById(int $tutoringId): ?Tutoring
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM tutoring
            JOIN subjects ON tutoring.subject_id = subjects.subject_id
            WHERE tutoring_id = :tutoring_id
        ');

        $stmt->bindParam(':tutoring_id', $tutoringId, PDO::PARAM_INT);
        $stmt->execute();

        $tutoringData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tutoringData === false) {
            return null;
        }

        $subject = $this->subjectRepository->getSubjectById($tutoringData['subject_id']);
        $creator = $this->userRepository->getUserById($tutoringData['creator_id']);

        $tutoring = new Tutoring(
            $subject,
            $tutoringData['date'],
            $tutoringData['duration'],
            $tutoringData['price'],
            $creator,
            $tutoringData['description']
        );

        $tutoring->setId($tutoringData['tutoring_id']);

        $participants = $this->getTutoringParticipants($tutoringId);
        foreach ($participants as $participant) {
            $tutoring->addParticipant($participant);
        }

        return $tutoring;
    }

    private function getTutoringParticipants(int $tutoringId): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT users.* FROM users
            JOIN participants ON users.user_id = participants.user_id
            WHERE participants.tutoring_id = :tutoring_id
        ');

        $stmt->bindParam(':tutoring_id', $tutoringId, PDO::PARAM_INT);
        $stmt->execute();

        $participants = [];
        while ($participantData = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $participants[] = new User(
                $participantData['email'],
                $participantData['password'],
            );
        }

        return $participants;
    }

    public function saveTutoring(Tutoring $tutoring)
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO tutoring (date, price, creator_id, subject_id, description,duration)
            VALUES (:date, :price, :creator_id, :subject_id, :description,:duration)
        ');

        $stmt->bindValue(':date', $tutoring->getDate());
        $stmt->bindValue(':price', $tutoring->getPrice());
        $stmt->bindValue(':creator_id', $tutoring->getCreator()->getId());
        $stmt->bindValue(':subject_id', $tutoring->getSubject()->getId());
        $stmt->bindValue(':description', $tutoring->getDescription());
        $stmt->bindValue(':duration', $tutoring->getDuration());
        $stmt->execute();

        $tutoringId = $this->database->connect()->lastInsertId();

        foreach ($tutoring->getParticipants() as $participant) {
            $this->saveParticipant($participant->getId(), $tutoringId);
        }
    }

    private function saveParticipant(int $userId, int $tutoringId)
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO participants (user_id, tutoring_id)
            VALUES (:user_id, :tutoring_id)
        ');

        $stmt->bindValue(':user_id', $userId);
        $stmt->bindValue(':tutoring_id', $tutoringId);

        $stmt->execute();
    }


    public function getAllTutorings(): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM tutoring
            JOIN subjects ON tutoring.subject_id = subjects.subject_id
        ');
    
        $stmt->execute();
    
        $tutorings = [];
        while ($tutoringData = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $subject = $this->subjectRepository->getSubjectById($tutoringData['subject_id']);
            $creator = $this->userRepository->getUserById($tutoringData['creator_id']);
            $tutoring = new Tutoring(
                $subject,
                $tutoringData['date'],
                $tutoringData['duration'],
                $tutoringData['price'],
                $creator,
                $tutoringData['description']
            );
    
            $tutoring->setId($tutoringData['tutoring_id']);
    
            $participants = $this->getTutoringParticipants($tutoringData['tutoring_id']);
            foreach ($participants as $participant) {
                $tutoring->addParticipant($participant);
            }
    
            $tutorings[] = $tutoring;
        }
    
        return $tutorings;
    }

    public function getTutoringsByUserId(int $userId): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT tutoring.* FROM tutoring
            JOIN participants ON tutoring.tutoring_id = participants.tutoring_id
            WHERE participants.user_id = :user_id
        ');
    
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
    
        $tutorings = [];
        
        while ($tutoringData = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $creator = $this->userRepository->getUserById($tutoringData['creator_id']);
            $subject = $this->subjectRepository->getSubjectById($tutoringData['subject_id']);
            $tutoring = new Tutoring(
                $subject,
                $tutoringData['date'],
                $tutoringData['duration'],
                $tutoringData['price'],
                $creator,
                $tutoringData['description']
            );
    
            $tutoring->setId($tutoringData['tutoring_id']);
            $participants = $this->getTutoringParticipants($tutoringData['tutoring_id']);
            foreach ($participants as $participant) {
                $tutoring->addParticipant($participant);
            }
    
            $tutorings[] = $tutoring;
        }
    
        return $tutorings;
    }

}
