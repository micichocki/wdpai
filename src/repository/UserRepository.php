<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/User.php';

class UserRepository extends Repository
{
    private static $instance;
    private $userCredentialsRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userCredentialsRepository = UserCredentialsRepository::getInstance();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getUserById(int $userId): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.users WHERE user_id = :user_id
        ');
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            throw new Exception("404");
        }

        $newUser = new User($user['email'], $user['password']);

        if (isset($user['user_credentials_id'])) {
            $userCredentials = $this->userCredentialsRepository->getUserCredentialsByUserId($userId);
            $newUser->setUserCredentials($userCredentials);
        }

        return $newUser;
    }

    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.users WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
        }

        $loggedUser =  new User(
            $user['email'],
            $user['password'],
        );

        $loggedUser->setId($user['user_id']);
        return $loggedUser;
    }

    public function addUser(User $user)
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO users (email, password)
            VALUES (?, ?)
            RETURNING user_id
        ');

        $stmt->execute([
            $user->getEmail(),
            $user->getPassword(),
        ]);

        $userId = $stmt->fetchColumn();

        $user->setId($userId);
    }

    public function getAllUsers(): array
    {
        $stmt = $this->database->connect()->query('SELECT * FROM public.users');
        $usersData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach ($usersData as $userData) {
            $user = new User($userData['email'], $userData['password']);

            if (isset($userData['user_credentials_id'])) {
                $userCredentials = $this->userCredentialsRepository->getUserCredentialsByUserId($userData['user_id']);
                $user->setUserCredentials($userCredentials);
            }

            $user->setId($userData['user_id']);
            $users[] = $user;
        }

        return $users;
    }

    public function isUserPrivileged(int $userId): bool
    {
        $stmt = $this->database->connect()->prepare('
        SELECT privileged FROM public.users WHERE user_id = :user_id
    ');
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchColumn();

        if ($result === false) {
            throw new Exception("404");
        }

        return (bool)$result;
    }

    public function deleteUser(int $userId)
    {
        $database = $this->database->connect();
        $database->beginTransaction();
    
        try {
            $stmtFindCredentialsId = $database->prepare('SELECT user_credentials_id FROM public.users WHERE user_id = :user_id');
            $stmtFindCredentialsId->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmtFindCredentialsId->execute();
            $userCredentialsId = $stmtFindCredentialsId->fetchColumn();

            $stmtDeleteUser = $database->prepare('DELETE FROM public.users WHERE user_id = :user_id');
            $stmtDeleteUser->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $success = $stmtDeleteUser->execute();
    
    
            $stmtDeleteCredentials = $database->prepare('DELETE FROM public.usercredentials WHERE user_credentials_id = :user_credentials_id');
            $stmtDeleteCredentials->bindParam(':user_credentials_id', $userCredentialsId, PDO::PARAM_INT);
            $stmtDeleteCredentials->execute();
    

            if ($success) {
                $stmtDeleteTutoring = $database->prepare('DELETE FROM public.tutoring WHERE creator_id = :user_id');
                $stmtDeleteTutoring->bindParam(':user_id', $userId, PDO::PARAM_INT);
    
                if ($this->userHasTutorings($userId)) {
                    $stmtDeleteTutoring->execute();
                }
            }
    
            $database->commit();
            return $success;
        } catch (Exception $e) {
            $database->rollBack();
            throw $e;
        }
    }

    private function userHasTutorings($userId): bool
    {
        $stmt = $this->database->connect()->prepare('SELECT 1 FROM public.tutoring WHERE creator_id = :user_id LIMIT 1');
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }
}
