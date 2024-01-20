<?php
require_once 'AppController.php';
require_once __DIR__ . '/../repository/UserRepository.php';


class AdminController extends AppController
{
    private $userRepository;


    public function __construct()
    {
        parent::__construct();
        $this->userRepository = UserRepository::getInstance();
    }


    public function admin_panel()
    {
        $isPrivileged = $this->userRepository->isUserPrivileged($_SESSION['user_id']);
        if ($isPrivileged) {
            $allUsers = $this->userRepository->getAllUsers();
            $this->render('admin-panel', ['allUsers' => $allUsers]);
        } else {
            throw new Exception("401");
        }
    }
    public function delete_user()
    {
        header('Content-Type: application/json');
    
        if ($this->isPost()) {
            $data = json_decode(file_get_contents("php://input"));
    
            if (isset($data->userId)) {
                $userId = $data->userId;
                $success = $this->userRepository->deleteUser($userId);
    
                if ($success) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Failed to remove user']);
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
}
