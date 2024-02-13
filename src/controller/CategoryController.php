<?php

require_once 'AppController.php';
require_once __DIR__ . '/../model/Category.php';
require_once __DIR__ . '/../repository/CategoryRepository.php';


class CategoryController extends AppController
{
    private $categoryRepository;

    public function __construct()
    {
        parent::__construct();
        $this->categoryRepository = new CategoryRepository();
    }
    public function addCategory()
    {
        if ($this->isPost() && isset($_POST['category_name'])) {
            $categoryName = $_POST['category_name'];

            $category = new Category($categoryName);

            $this->categoryRepository->addCategory($category);

            return $this->render('videos', ['messages' => $this->messages]);
        }

        return $this->render('add_category', ['messages' => $this->messages]);
    }


}