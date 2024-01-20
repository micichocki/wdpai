<?php
require_once 'AppController.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/SubjectRepository.php';
require_once __DIR__ . '/../repository/TutoringRepository.php';
require_once __DIR__ . '/../repository/ParticipantsRepository.php';

class TutorController extends AppController
{
    private $userRepository;
    private $subjectRepository;
    private $tutoringRepository;
    private $userCredentialsRepository;
    private $participantsRepository;


    public function __construct()
    {
        parent::__construct();
        $this->userRepository = UserRepository::getInstance();
        $this->subjectRepository = SubjectRepository::getInstance();
        $this->tutoringRepository = TutoringRepository::getInstance();
        $this->userCredentialsRepository = UserCredentialsRepository::getInstance();
        $this->userCredentialsRepository = UserCredentialsRepository::getInstance();
        $this->participantsRepository = ParticipantsRepository::getInstance();
    }


    public function dashboard()
    {
        $this->checkAuthentication();
        $this->checkUserCredentials();
    
        if ($this->isGet()) {
            $allTutorings = $this->tutoringRepository->getAllTutorings();
            $userId = $_SESSION['user_id'];
            $userTutorings = $this->tutoringRepository->getTutoringsByUserId($userId);
    
            $filteredAllTutorings = $this->tutoringRepository->filterAssignedTutorings($allTutorings, $userTutorings);
    
            $this->render('dashboard', [
                'allTutorings' => $filteredAllTutorings,
                'userAssignedTutorings' => $userTutorings,
            ]);
        } else {
            throw new Exception("405");
        }
    }

    public function profile()
    {
        $this->checkAuthentication();
        $this->checkUserCredentials();
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $user = $this->userRepository->getUserById($userId);

        if ($this->isGet()) {
            if ($userId !== null) {
                if ($user !== null) {
                    $this->render('profile', ['user' => $user]);
                } else {
                    $this->render('register');
                }
            } else {
                $this->render('register');
            }
        } elseif ($this->isPost()) {
            if (isset($_POST['email']) && isset($_POST['city'])) {
                $email = $_POST['email'];
                $city = $_POST['city'];
                $userCredentials = $user->getUserCredentials();
                if (!empty($email)) {
                    $user->setEmail($email);
                }
                if (!empty($city)) {
                    $userCredentials->setCity($city);
                }
                $user->setId($userId);
                $this->userCredentialsRepository->updateUserCredentials($user, $userCredentials);

                header('Location: /profile');
                exit();
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
        } elseif ($this->isPost()) {
            $date = $_POST['date'] ?? '';
            $price = $_POST['price'] ?? '';
            $description = $_POST['description'] ?? '';
            $duration = $_POST['duration'] ?? '';
            $creatorId = $_SESSION['user_id'];

            $creator = $this->userRepository->getUserById($creatorId);
            $creator->setId($creatorId);
            $subject = new Subject($_POST['subject']);

            if ($creator === null || $subject === null) {
                return;
            }

            $tutoring = new Tutoring($subject, $date, $duration, $price, $creator, $description);
            $this->tutoringRepository->saveTutoring($tutoring);
            header('Location: /dashboard');
            exit();
        } else {
            throw new Exception("405");
        }
    }

    public function add_participation()
    {
        header('Content-Type: application/json');

        if ($this->isPost()) {
            $data = json_decode(file_get_contents("php://input"));

            if (isset($data->tutoringId)) {
                $userId = $_SESSION['user_id'];
                $tutoringId = $data->tutoringId;

                $success = $this->participantsRepository->saveParticipation($userId, $tutoringId);

                if ($success) {
                    echo json_encode(['success' => true, ]);
                } else {
                    echo json_encode(['success' => false]);
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'Invalid request']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid request method']);
        }
    }

    public function delete_participation()
    {
        header('Content-Type: application/json');

        if ($this->isPost()) {
            $data = json_decode(file_get_contents("php://input"));

            if (isset($data->tutoringId)) {
                $tutoringId = $data->tutoringId;
                $success = $this->participantsRepository->deleteParticipation($tutoringId);

                if ($success) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Failed to remove participation']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Invalid request']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Invalid request method']);
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
