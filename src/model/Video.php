<?php

class Video
{
    private $title;
    private $categories = [];
    private $video;
    private $id;

    public function __construct($title, $video, $categories = null, $id = null)
    {
        $this->title = $title;
        $this->video = $video;
        $this->categories = $categories;
        $this->id = $id;

    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    public function addCategory(Category $category)
    {
        if (!in_array($category, $this->categories)) {
            $this->categories[] = $category;
        }
    }

    public function removeCategory(Category $category)
    {
        $index = array_search($category, $this->categories);
        if ($index !== false) {
            array_splice($this->categories, $index, 1);
        }
    }

    public function getVideo()
    {
        return $this->video;
    }

    public function setVideo($video): void
    {
        $this->video = $video;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }



}