<?php

namespace App\Controller\Ajax;

use App\Entity\Trophy;
use App\Repository\ExerciceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/_")
 */
class RequestController extends AbstractController
{
    /**
     * @Route("/exec", name="r_exec")
     */
    public function execute(Request $request, ExerciceRepository $repository)
    {
        $sendedRequest = $request->get('request');
        if (strpos($sendedRequest, 'DROP') === false && strpos($sendedRequest, 'ALTER') === false && strpos($sendedRequest, 'CREATE') === false) {
            $em = $this->getDoctrine()->getConnection('student');
            $req = $em->prepare($sendedRequest);
            $q = $request->get('exo');
            $question = $repository->find($q);
            $reponse = $em->prepare($question->getResultat());
            try {
                $req->execute();
                $reponse->execute();
                $result = $req->fetchAll();
                $rep = $reponse->fetchAll();
                $win = ($rep === $result);
                return $this->json(['response' => $result, 'win' => $win]);
            } catch (\Exception $exception) {
                return $this->json(['error' => $exception->getMessage()]);
            }
        } else {
            return $this->json(['error' => 'CREATE ? DROP ? ALTER ? It\'s forbidden dude !']);
        }
    }

    /**
     * @Route("/complete/{code}", name="r_complete")
     */
    public function complete(Request $request, $code)
    {
        $trophy = new Trophy();
        $em = $this->getDoctrine()->getManager();
        try {
            $trophy->setSutdent($this->getUser());
            $trophy->setTheme($code);
            $em->persist($trophy);
            $em->flush();
            return $this->json(['response' => $this->generateUrl('student_dash')]);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()]);
        }
    }
}
