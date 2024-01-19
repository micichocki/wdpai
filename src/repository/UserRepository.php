<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

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
            $userCredentials=$this->userCredentialsRepository->getUserCredentialsByUserId($userId);
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

    
}