<?php


namespace App\Service;


use App\Repository\ThemeRepository;

class ThemeLister
{
    private $themes;
    public function __construct(ThemeRepository $repository)
    {
        $this->themes = $repository->findAll();
    }
    public function getAll() {
        return $this->themes;
    }
}