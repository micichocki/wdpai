<?php
require_once 'AppController.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/SubjectRepository.php';
require_once __DIR__ . '/../repository/TutoringRepository.php';


class TutorController extends AppController
{
    private $userRepository;
    private $subjectRepository;
    private $tutoringRepository;


    public function __construct()
    {
        parent::__construct();
        $this->userRepository = UserRepository::getInstance();
        $this->subjectRepository = SubjectRepository::getInstance();
        $this->tutoringRepository = TutoringRepository::getInstance();
    }


    public function dashboard()
    {
        $this->checkAuthentication();
        $this->checkUserCredentials();
        if ($this->isGet()) {
            $this->render('dashboard');
        } else {
            throw new Exception("405");
        }
    }

    public function profile()
    {
        $this->checkAuthentication();
        $this->checkUserCredentials();
        if ($this->isGet()) {
            $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
            if ($userId !== null) {
                $user = $this->userRepository->getUserById($userId);
                if ($user !== null) {
                    $this->render('profile', ['user' => $user]);
                } else {
                    $this->render('register');
                }
            } else {
                $this->render('register');
            }
        } else {
            throw new Exception("405");
        }
    }

    public function tutoring()
    {
        $this->checkAuthentication();
        $this->checkUserCredentials();
        if ($this->isGet()) {
            $subjects = $this->subjectRepository->getAllSubjects();
            $this->render('tutoring', ['subjects' => $subjects]);
        } else if ($this->isPost()) {
            $subjectId = $_POST['subject'] ?? '';
            $date = $_POST['date'] ?? '';
            $price = $_POST['price'] ?? '';
            $description = $_POST['description'] ?? '';
            $creatorId = $_SESSION['user_id'];

            $creator = $this->userRepository->getUserById($creatorId);

            if ($creator === null) {
                return;
            }

            $tutoring = new Tutoring($subjectId, $date, $price, $creator, $description);
            $this->tutoringRepository->saveTutoring($tutoring);
        }else{
            throw new Exception("405");
        }
    }

    private function checkAuthentication()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /register");
        }
    }

    private function checkUserCredentials()
    {
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $user = $this->userRepository->getUserById($userId);
        if (!$user->getUserCredentials()) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/user_credentials");
            exit();
        }
    }
}