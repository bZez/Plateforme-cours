<?php

namespace App\Controller\Student;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/s")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="student_dash")
     */
    public function index()
    {
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
}
