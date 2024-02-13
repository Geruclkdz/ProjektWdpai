<?php

require_once 'Repository.php';
require_once __DIR__ . '/../model/Category.php';

class ReportRepository extends Repository
{
    public function addReport(Report $report)
    {
        $pdo = $this->database->connect();

        $stmt = $pdo->prepare('
            INSERT INTO reports (id_users, title, type, description)
            VALUES (?, ?, ?, ?)
        ');


        $stmt->execute([
            $_SESSION['user']['id'],
            $report->getTitle(),
            $report->getType(),
            $report->getDescription()
        ]);

    }

    public function getReports()
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM reports 
        ');

        $stmt->execute();

        $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $reports;

    }
}