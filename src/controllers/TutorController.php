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
            $email = strtolower($_POST['email']);
            $city = $_POST['city'];
            $userCredentials = $user->getUserCredentials();
    
            $existingUserWithEmail = $this->userRepository->getUser($email);
            if ($existingUserWithEmail && $existingUserWithEmail->getId() !== $userId) {
                return $this->render('profile', ['messages' => ['Email is already in use.'], 'user' => $user]);
            }
    
            if (!empty($city)) {
                $city = ucfirst($city);
                if (!preg_match('/^[A-Za-zęóąśłżźćńĘÓĄŚŁŻŹĆŃ\s]+$/', $city)) {
                    return $this->render('profile', ['messages' => ['Invalid city format. Use only letters.'], 'user' => $user]);
                }
                $userCredentials->setCity($city);
            }
            
    
            if (!empty($email)) {
                $user->setEmail($email);
            }
    
            $user->setId($userId);
            $this->userCredentialsRepository->updateUserCredentials($user, $userCredentials);
    
            if (strlen($email) <= 4 && strlen($email) != 0) {
                return $this->render('profile', ['messages' => ['Email is too short.'], 'user' => $user]);
            }
    
            header('Location: /profile');
            exit();
        } else {
            throw new Exception("405");
        }
    }

    public function tutoring()
    {
        $this->checkAuthentication();
        $this->checkUserCredentials();
        $subjects = $this->subjectRepository->getAllSubjects();
        if ($this->isGet()) {
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
                throw new Exception("403");
            }

            $currentTimestamp = time();
            $inputTimestamp = strtotime($date);

            if ($inputTimestamp < $currentTimestamp) {
                return $this->render('tutoring', ['messages' => ['Wrong date provided'], 'subjects' => $subjects]);
            }

            $currentYear = date('Y');
            $inputYear = date('Y', $inputTimestamp);

            if ($inputYear > $currentYear + 2) {
                return $this->render('tutoring', ['messages' => ['Wrong date provided'], 'subjects' => $subjects]);
            }

            if ($price > 1000 || $price <= 0) {
                return $this->render('tutoring', ['messages' => ['Wrong price provided'], 'subjects' => $subjects]);
            }

            if (!preg_match('/^\d+:\d{2}$/', $duration)) {
                return $this->render('tutoring', ['messages' => ['Wrong date provided'], 'subjects' => $subjects]);
            }

            list($hours, $minutes) = explode(':', $duration);
            if ($hours > 5) {
                return $this->render('tutoring', ['messages' => ['Hour should not be greater than 5'], 'subjects' => $subjects]);
            }

            if (preg_match('/\b(SELECT|INSERT|UPDATE|DELETE|FROM|WHERE)\b/i', $description)) {
                return $this->render('tutoring', ['messages' => ['Invalid description'], 'subjects' => $subjects]);
            }

            if (strlen($description) < 10) {
                return $this->render('tutoring', ['messages' => ['Description too short'], 'subjects' => $subjects]);
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
                    echo json_encode(['success' => true,]);
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
        try {
            $user = $this->userRepository->getUserById($userId);
        } catch (Exception $e) {
            session_destroy();
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/register");
        }

        if (!$user->getUserCredentials()) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/user_credentials");
            exit();
        }
    }
}
