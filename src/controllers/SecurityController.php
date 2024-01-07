<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController
{
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = UserRepository::getInstance();
    }

    public function login()
    {
        session_start();
    
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
    
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/dashboard");
    }

    public function register()
    {
        if (!$this->isPost()) {
            return $this->render('register');
        }
    
        $email = $_POST['email'];
        $password = $_POST['password'];
        $retype_password = $_POST['retype-password'];
    
        
        if (strlen($password) < 4) {
            return $this->render('register', ['messages' => ['Password is too short.']]);
        }
    
        if ($password !== $retype_password) {
            return $this->render('register', ['messages' => ['Passwords do not match.']]);
        }
    
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
        $user = new User($email, $hashedPassword);
    
        $this->userRepository->addUser($user);
    
        return $this->render('login', ['messages' => ['Registration successful!']]);
    }
}
