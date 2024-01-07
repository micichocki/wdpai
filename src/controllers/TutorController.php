<?php

require_once 'AppController.php';

class TutorController extends AppController
{
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = UserRepository::getInstance();
    }


    public function dashboard()
    {
        $this->checkAuthentication(); 
        if ($this->isGet()) {
            $this->render('dashboard');
        } else {
            throw new Exception("405");
        }
    }

    public function profile()
    {
        $this->checkAuthentication(); 
        if ($this->isGet()) {
            $userId = $_SESSION['user_id'];
    
            $user = $this->userRepository->getUserById($userId);
    
            if ($user !== null) {
                $this->render('profile', ['user' => $user]);
            } else {
                $this->render('register');
            }
        } else {
            throw new Exception("405");
        }
    }

    public function tutoring()
    {
        // $this->checkAuthentication(); 
        if ($this->isGet()) {
            $this->render('tutoring');
        } else {
            throw new Exception("405");
        }
    }

    private function checkAuthentication()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /register");
        }
    }
    
}
