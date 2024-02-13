<?php

require_once 'AppController.php';
require_once __DIR__ . '/../model/Video.php';
require_once __DIR__ . '/../repository/VideoRepository.php';
require_once __DIR__ . '/../repository/CategoryRepository.php';


class VideoController extends AppController
{
    const MAX_FILE_SIZE = 1024 * 1024 * 10000;
    const SUPPORTED_TYPES = ['video/mp4', 'video/avi', 'video/mov', 'video/mkv', 'video/wmv'];
    const UPLOAD_DIRECTORY = '/../public/uploads/videos/';
    private $messages = [];
    private $videoRepository;

    public function __construct()
    {
        parent::__construct();
        $this->videoRepository = new VideoRepository();
    }

    public function videos()
    {
        if(!isset($_SESSION['user'])){
            $this->render('login', ['messages' => ['Please log in to continue']]);
            exit();
        }
        $this->render('videos');
    }

    public function addVideo()
    {
        if(!isset($_SESSION['user'])){
            $this->render('login', ['messages' => ['Please log in to continue']]);
            exit();
        }

        if ($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {
            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['file']['name']
            );

            $video = new Video($_POST['title'],"/public/uploads/videos/". $_FILES['file']['name']
            );
            $this->videoRepository->addVideo($video);

            return $this->render('videos', ['messages' => $this->messages]);
        }
        return $this->render('add_video', ['messages' => $this->messages]);
    }

    public function search()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            header('Content-type: application/json');
            http_response_code(200);

            $videos = $this->videoRepository->getVideoByTitle($decoded['search']);
            echo json_encode($videos);
        }
    }

    public function displayCategory()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            header('Content-type: application/json');
            http_response_code(200);

            $videos = $this->videoRepository->getVideoByTitle($decoded['search']);
            echo json_encode($videos);
        }
    }


    public function addCategoryToVideo(int $id_video, int $id_category){
       $this->videoRepository->addCategoryToVideo($id_video, $id_category);
       http_response_code(200);
    }

    public function removeCategoryFromVideo(int $id_video, int $id_category){
        $this->videoRepository->removeCategoryFromVideo($id_video, $id_category);
        http_response_code(200);
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