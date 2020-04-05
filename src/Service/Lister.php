<?php


namespace App\Service;


use App\Repository\CoursRepository;
use App\Repository\ThemeRepository;

class Lister
{
    private $themes;
    private $cours;
    public function __construct(ThemeRepository $themeRepository,CoursRepository $coursRepository)
    {
        $this->themes = $themeRepository->findAll();
        $this->cours = $coursRepository->findAll();
    }
    public function themes() {
        return $this->themes;
    }
    public function cours() {
        return $this->cours;
    }
}