<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Tutoring.php';

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
            SELECT * FROM public.tutorings WHERE tutoring_id = :tutoring_id
        ');
        $stmt->bindParam(':tutoring_id', $tutoringId, PDO::PARAM_INT);
        $stmt->execute();

        $tutoringData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tutoringData === false) {
            return null;
        }

        $tutoring = new Tutoring(
            $tutoringData['subject'],
            $tutoringData['date'],
            $tutoringData['price'],
            $tutoringData['creator'],
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
            JOIN tutoring_participants ON users.user_id = tutoring_participants.participant_id
            WHERE tutoring_participants.tutoring_id = :tutoring_id
        ');
        $stmt->bindParam(':tutoring_id', $tutoringId, PDO::PARAM_INT);
        $stmt->execute();

        $participants = [];
        while ($participantData = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $participants[] = new User(
                $participantData['email'],
                $participantData['password'],
                $participantData['name'],
                $participantData['surname']
            );
        }

        return $participants;
    }
    public function saveTutoring(Tutoring $tutoring)
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO public.tutorings (subject, date, price, creator, description)
            VALUES (:subject, :date, :price, :creator, :description)
        ');

        $stmt->bindValue(':subject', $tutoring->getSubject());
        $stmt->bindValue(':date', $tutoring->getDate());
        $stmt->bindValue(':price', $tutoring->getPrice());
        $stmt->bindValue(':creator', $tutoring->getCreator()->getId()); // Assuming getId returns the user ID
        $stmt->bindValue(':description', $tutoring->getDescription());

        $stmt->execute();
    }
}
