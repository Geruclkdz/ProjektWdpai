<?php

require_once 'AppController.php';
require_once __DIR__ . '/../model/Report.php';
require_once __DIR__ . '/../repository/ReportRepository.php';


class ReportController extends AppController
{

    private $reportRepository;

    public function __construct()
    {
        parent::__construct();
        $this->reportRepository = new reportRepository();

    }

    public function sendForm()
    {
        if(!isset($_SESSION['user'])){
            $this->render('login', ['messages' => ['Please log in to continue']]);
            exit();
        }

        if ($this->isPost() && isset($_POST['title'])) {
            $reportTitle = $_POST['title'];
            $reportDescription = $_POST['description'];
            $reportType = isset($_POST['report_bug']) ? 'Report Bug' : 'Suggest Functionality';
            $report = new Report($reportTitle, $reportDescription, $reportType);

            $this->reportRepository->addReport($report);

            return $this->render('videos');
        }

        return $this->render('application_form', ['messages' => $this->messages]);
    }

    public function viewForm()
    {

        if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== "admin") {
            $this->render('videos', ['messages' => ['You are not an admin!']]);
            exit();
        }

        if ($this->isGet()) {
            $this->render('application_form_admin');
        }
    }

}