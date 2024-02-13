<?php

require_once 'Repository.php';
require_once __DIR__ . '/../model/Category.php';

class CategoryRepository extends Repository
{
//    public function getCategory(string $name): ?Category
//    {
//        $stmt = $this->database->connect()->prepare('
//            SELECT * FROM public.categories WHERE name = :name
//        ');
//        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
//        $stmt->execute();
//
//        $category = $stmt->fetch(PDO::FETCH_ASSOC);
//
//        if ($category == false) {
//            return null;
//        }
//
//        return new Category($category['name'], $category['id']);
//    }

    public function addCategory(Category $category)
    {
        $pdo = $this->database->connect();

        $stmtCategories = $pdo->prepare('
            INSERT INTO categories (name)
            VALUES (?)
        ');

        $stmtCategories->execute([$category->getName()]);
        $user_Id = $_SESSION['user']['id'];
        $categoryId = $pdo->lastInsertId();

        $stmtUserCategories = $pdo->prepare('
        INSERT INTO users_categories (id_users, id_categories)
        VALUES (?, ?)
    ');

        $stmtUserCategories->execute([$user_Id, $categoryId]);
    }

    public function addVideoToCategory(int $categoryId, int $videoId)
    {
        $stmt = $this->database->connect()->prepare('INSERT INTO videos_categories (id_videos, id_categories) VALUES (?, ?)');
        $stmt->execute([$videoId, $categoryId]);
    }

    public function getCategories()
    {
        $userId = $_SESSION['user']['id'];
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM categories c
            JOIN users_categories uc ON c.id = uc.id_categories
            WHERE uc.id_users = :userId
        ');

        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($categories as $category) {
            $newCategory = new Category($category['name']);
            $newCategory->setId($category['id']);
            $result[] = $newCategory;
        }
        return $result;
    }

}