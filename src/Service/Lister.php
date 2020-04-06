<?php


namespace App\Service;


use App\Repository\CoursRepository;
use App\Repository\QuizRepository;
use App\Repository\ThemeRepository;

class Lister
{
    private $themes;
    private $cours;
    private $quizs;
    public function __construct(ThemeRepository $themeRepository,CoursRepository $coursRepository,QuizRepository $quizRepository)
    {
        $this->themes = $themeRepository->findAll();
        $this->cours = $coursRepository->findAll();
        $this->quizs = $coursRepository->findAll();
    }
    public function themes() {
        return $this->themes;
    }
    public function cours() {
        return $this->cours;
    }
    public function quizs() {
        return $this->quizs();
    }
}