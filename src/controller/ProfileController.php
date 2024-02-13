<?php

require_once 'AppController.php';
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class ProfileController extends AppController
{
    const MAX_FILE_SIZE = 1024 * 1024 * 10000;
    const SUPPORTED_TYPES = ['image/jpg', 'image/png'];
    const UPLOAD_DIRECTORY = '/../public/uploads/profile_pictures/';
    private $messages = [];

    public function profile()
    {
        if(!isset($_SESSION['user'])){
            $this->render('login', ['messages' => ['Please log in to continue']]);
            exit();
        }

        if ($this->isGet()) {
            $this->render('profile');
        }
    }

    public function edit_profile()
    {
        if (!isset($_SESSION['user'])) {
            $this->render('login', ['messages' => ['Please log in to continue']]);
            exit();
        }

        if ($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {
            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['file']['name']
            );

            $userEmail = $_SESSION['user']['email'];
            $userRepository = new UserRepository();
            $user = $userRepository->getUser($userEmail);
            $dateOfBirth = new DateTime($_POST['date_of_birth']);
            $today = new DateTime('now');
            $age = $today->diff($dateOfBirth)->y;
            $user->setName($_POST['name']);
            $user->setSurname($_POST['surname']);
            $user->setAge($age);
            $user->setProfilePicture("/public/uploads/profile_pictures/" . $_FILES['file']['name']);
            $user->setDescription($_POST['description']);

            $userRepository->addUserDetails($user);


            return $this->render('profile', ['messages' => $this->messages]);
        }
        return $this->render('edit_profile', ['messages' => $this->messages]);
    }

    private function validate(array $file): bool
    {
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $this->messages[] = 'File is too large for destination file system.';
            return false;
        }

        if (!isset($file['type']) && !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->messages[] = 'File type is not supported.';
            return false;
        }
        return true;
    }

}