<?php

require_once 'Repository.php';

class ParticipantsRepository extends Repository
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function saveParticipation(int $userId, int $tutoringId): bool
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO participants (user_id, tutoring_id) VALUES (:user_id, :tutoring_id)
        ');

        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':tutoring_id', $tutoringId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteParticipation(int $tutoringId): bool
    {
        $stmt = $this->database->connect()->prepare('
            DELETE FROM participants WHERE tutoring_id = :tutoring_id
        ');

        $stmt->bindParam(':tutoring_id', $tutoringId, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
