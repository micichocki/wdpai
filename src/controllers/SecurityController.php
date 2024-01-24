<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/UserCredentialsRepository.php';

class SecurityController extends AppController
{
    private $userRepository;
    private $userCredentialsRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = UserRepository::getInstance();
        $this->userCredentialsRepository = UserCredentialsRepository::getInstance();
    }

    public function login()
    {
        $this->checkAuthentication();
        if (!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->userRepository->getUser($email);

        if (!$user) {
            return $this->render('login', ['messages' => ['Wrong credentials!']]);
        }

        if (!password_verify($password, $user->getPassword())) {
            return $this->render('login', ['messages' => ['Wrong credentials!']]);
        }

        $_SESSION['user_id'] = $user->getId();

        if (!$user->getUserCredentials()) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/user_credentials");
            exit();
        }

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/dashboard");
        exit();
    }

    public function register()
    {
        $this->checkAuthentication();
    
        if (!$this->isPost()) {
            return $this->render('register');
        }
    
        $email = $_POST['email'];
        $password = $_POST['password'];
        $retype_password = $_POST['retype-password'];

        if (strlen($email) < 4) {
            return $this->render('register', ['messages' => ['Email is too short.']]);
        }
    
        if (strlen($password) < 4) {
            return $this->render('register', ['messages' => ['Password is too short.']]);
        }
    
        if ($password !== $retype_password) {
            return $this->render('register', ['messages' => ['Passwords do not match.']]);
        }
    
        $allUsers = $this->userRepository->getAllUsers();
    
        foreach ($allUsers as $existingUser) {
            if ($existingUser->getEmail() === $email || password_verify($password, $existingUser->getPassword())) {
                return $this->render('register', ['messages' => ['User Exists']]);
            }
        }
    
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $user = new User($email, $hashedPassword);
        $this->userRepository->addUser($user);
    
        return $this->render('login', ['messages' => ['Registration successful!']]);
    }

    public function logout()
    {
        session_destroy();
        $_SESSION = array();
        session_write_close();
        unset($_SESSION['user_id']);

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/");
        exit();
    }

    public function user_credentials()
    {
        $this->isSessionCorrect();
        $userId = $_SESSION['user_id'];
        $user = $this->userRepository->getUserById($userId);
    
        if ($this->isGet()) {
            if ($user->getUserCredentials()) {
                $url = "http://$_SERVER[HTTP_HOST]";
                header("Location: {$url}/dashboard");
                exit();
            }
            return $this->render('user_credentials');
        } else if ($this->isPost()) {
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $city = $_POST['city'];
    
            if (strlen($name) >= 2 && strlen($name) <= 20 && strlen($surname) >= 2 && strlen($surname) <= 20) {    
                $newUserCredential = new UserCredentials($name, $surname, $city);
                $this->userCredentialsRepository->addUserCredentials($userId, $newUserCredential);
    
                $url = "http://$_SERVER[HTTP_HOST]";
                header("Location: {$url}/dashboard");
                exit();
            } else {
                return $this->render('user_credentials', ['messages' => ["Invalid name or surname length. "]]);
            }
        } else {
            throw new Exception("405");
        }
    }

    private function isSessionCorrect()
    {
        if (!isset($_SESSION['user_id'])) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/login");
            exit();
        }
    }

    private function checkAuthentication()
    {
        if (isset($_SESSION['user_id'])) {
            header("Location: /dashboard");
        }
    }
}
