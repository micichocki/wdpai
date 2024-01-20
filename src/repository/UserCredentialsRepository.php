<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/UserCredentials.php';

class UserCredentialsRepository extends Repository
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getUserCredentialsByUserId(int $userId): ?UserCredentials
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users WHERE user_id = :user_id
        ');
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false || empty($user['user_credentials_id'])) {
            return null;
        }

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM usercredentials WHERE user_credentials_id = :user_credentials_id
        ');

        $stmt->bindParam(':user_credentials_id', $user['user_credentials_id'], PDO::PARAM_INT);
        $stmt->execute();

        $userCredentialsData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userCredentialsData == false) {
            return null;
        }

        return new UserCredentials(
            $userCredentialsData['name'],
            $userCredentialsData['surname'],
            $userCredentialsData['city']
        );
    }

    public function addUserCredentials(int $userId, UserCredentials $userCredentials)
    {
        $pdo = $this->database->connect();

        $stmt = $pdo->prepare('
            INSERT INTO usercredentials (name, surname, city, date_of_join)
            VALUES (?, ?, ?, ?)
        ');

        $stmt->execute([
            $userCredentials->getName(),
            $userCredentials->getSurname(),
            $userCredentials->getCity(),
            $userCredentials->getDateOfJoin()
        ]);

        $userCredentialsId = $pdo->lastInsertId();

        $stmt = $pdo->prepare('
            UPDATE users
            SET user_credentials_id = :user_credentials_id
            WHERE user_id = :user_id
        ');

        $stmt->bindParam(':user_credentials_id', $userCredentialsId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateUserCredentials(User $user, UserCredentials $userCredentials)
    {
        $pdo = $this->database->connect();
    
        try {
            $pdo->beginTransaction();
    
            $stmtUser = $pdo->prepare("
                UPDATE users
                SET
                    email = :email
                WHERE user_id = :user_id
            ");
    
            $stmtUser->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
            $stmtUser->bindValue(':user_id', $user->getId(), PDO::PARAM_INT);
            $stmtUser->execute();
    
            $stmtCredentials = $pdo->prepare("
                UPDATE usercredentials
                SET
                    city = :city
                WHERE user_credentials_id = (
                    SELECT user_credentials_id
                    FROM users
                    WHERE user_id = :user_id
                )
            ");
    
            $stmtCredentials->bindValue(':city', $userCredentials->getCity(), PDO::PARAM_STR);
            $stmtCredentials->bindValue(':user_id', $user->getId(), PDO::PARAM_INT);
            $stmtCredentials->execute();
    
            $pdo->commit();
        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
}
