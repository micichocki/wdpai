<?php
require_once 'AppController.php';
require_once __DIR__ . '/../repository/UserRepository.php';


class TutorController extends AppController
{
    private $userRepository;


    public function __construct()
    {
        parent::__construct();
        $this->userRepository = UserRepository::getInstance();
    }


    public function admin_panel()
    {
        $this->checkAuthentication();
        $this->checkUserCredentials();

    }


}
