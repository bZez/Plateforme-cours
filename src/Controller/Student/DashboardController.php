<?php

namespace App\Controller\Student;

use App\Repository\QuizRepository;
use App\Student\Cours;
use App\Repository\CoursRepository;
use App\Repository\ThemeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/s")
 */
class DashboardController extends AbstractController
{
    private $themes;
    public function __construct(ThemeRepository $repository)
    {
        $this->themes = $repository;
    }

    public function theme($code) {
            return $this->themes->findOneBy(['code'=>$code]);
    }
    /**
     * @Route("/dashboard", name="student_dash")
     */
    public function index()
    {
        return $this->render('dashboard/index.html.twig', [
            'themes' => $this->themes->findAll(),
        ]);
    }
    /**
     * @Route("/exos/{code}", name="student_exos")
     */
    public function editor($code)
    {
        return $this->render('editor/editor.html.twig', [
            'theme' => $this->theme($code),
        ]);
    }

    /**
     * @Route("/cours/{x}", name="student_cours")
     */
    public function cours(CoursRepository $repository,$x)
    {
        $cours = $repository->findByTitre(str_replace('-',' ',$x));
        return $this->render('cours/index.html.twig',[
            'cours' => $cours
        ]);
    }

    /**
     * @Route("/quiz/{x}", name="student_quiz")
     */
    public function quiz(QuizRepository $repository,$x)
    {
        $quiz = $repository->findByTitre(str_replace('-',' ',$x));
        return $this->render('quiz/index.html.twig',[
            'quiz' => $quiz
        ]);
    }
}
