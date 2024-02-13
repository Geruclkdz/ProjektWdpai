<?php

require_once 'Repository.php';
require_once __DIR__.'/../model/Video.php';

class VideoRepository extends Repository
{

    public function getVideo(int $id): ?Video
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.videos WHERE id = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $video = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($video == false) {
            return null;
        }

        return new Video(
            $video['title'],
            $video['video']
        );

    }

    public function getVideos(): array
    {
        $loggedInUserId = $_SESSION['user']['id'];

        $stmt = $this->database->connect()->prepare('
        SELECT v.id, v.id_user, v.title, v.video, STRING_AGG(c.id::text, \',\') AS category_ids, STRING_AGG(c.name, \',\') AS category_names
        FROM videos v
        LEFT JOIN videos_categories vc ON v.id = vc.id_videos
        LEFT JOIN categories c ON vc.id_categories = c.id
        WHERE v.id_user = :userId
        GROUP BY v.id, v.id_user, v.title, v.video;
    ');

        $stmt->execute(['userId' => $loggedInUserId]);
        $videosData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $videos = [];

        foreach ($videosData as $videoData) {
            $categoryIds = explode(',', $videoData['category_ids']);
            $categoryNames = explode(',', $videoData['category_names']);

            $categories = [];
            foreach ($categoryIds as $index => $categoryId) {
                if (!empty($categoryId)) {
                    $categories[] = new Category($categoryNames[$index]);
                }
            }

            $videos[] = new Video(
                $videoData['title'],
                $videoData['video'],
                $categories,
                $videoData['id']
            );
        }

        return $videos;
    }


    public function addVideo(Video $video): void
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO public.videos(id_user, title, video)
            VALUES (?, ?, ?)
        ');

        $stmt->execute([
            $_SESSION['user']['id'],
            $video->getTitle(),
            $video->getVideo(),
        ]);
    }

    public function getVideoByTitle(string $searchString)
    {
        $searchString = '%' . strtolower($searchString) . '%';

        $stmt = $this->database->connect()->prepare('
        SELECT v.*, c.id AS category_id, c.name AS category_name
        FROM videos v
        LEFT JOIN videos_categories vc ON v.id = vc.id_videos
        LEFT JOIN categories c ON vc.id_categories = c.id
        WHERE LOWER(v.title) LIKE :search
    ');
        $stmt->bindParam(':search', $searchString, PDO::PARAM_STR);
        $stmt->execute();

        $videosData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $videos = [];
        foreach ($videosData as $videoData) {
            $videoId = $videoData['id'];

            // Check if the video is already in the $videos array
            if (!isset($videos[$videoId])) {
                $videos[$videoId] = [
                    'id' => $videoId,
                    'title' => $videoData['title'],
                    'video' => $videoData['video'],
                    'categories' => [],
                ];
            }

            // Add category only if it exists
            if (!is_null($videoData['category_id'])) {
                $videos[$videoId]['categories'][] = [
                    'id' => $videoData['category_id'],
                    'name' => $videoData['category_name'],
                ];
            }
        }

        return array_values($videos); // Re-index the array before returning
    }




    public function addCategoryToVideo(int $id_video, int $id_category){
        $stmt = $this->database->connect()->prepare('
        INSERT INTO videos_categories(id_videos, id_categories) 
        VALUES (?, ?)
        ');

        $stmt->execute([
            $id_video,
            $id_category
        ]);
    }

    public function removeCategoryFromVideo(int $id_video, int $id_category){
        $stmt = $this->database->connect()->prepare('
        DELETE FROM videos_categories
        WHERE id_videos = ? AND id_categories = ?
    ');

        $stmt->execute([
            $id_video,
            $id_category
        ]);
    }


}