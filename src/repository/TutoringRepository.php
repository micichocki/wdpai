<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Tutoring.php';
require_once __DIR__ . '/../models/User.php';

class TutoringRepository extends Repository
{
    private static $instance;

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
    
        $tutoring = new Tutoring(
            $tutoringData['subject_name'],
            $tutoringData['date_of_meeting'],
            $tutoringData['price'],
            $tutoringData['creator_id'],
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
            INSERT INTO tutoring (date_of_meeting, price, creator_id, subject_id, description)
            VALUES (:date, :price, :creator_id, :subject_id, :description)
        ');
    
        $stmt->bindValue(':date', $tutoring->getDate());
        $stmt->bindValue(':price', $tutoring->getPrice());
        $stmt->bindValue(':creator_id', $tutoring->getCreatorId());
        $stmt->bindValue(':subject_id', $tutoring->getSubjectId());
        $stmt->bindValue(':description', $tutoring->getDescription());
    
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
}
