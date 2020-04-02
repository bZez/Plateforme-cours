<?php

namespace App\Controller\Ajax;

use App\Repository\ExoSQLRepository;
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
    public function index(Request $request,ExoSQLRepository $repository)
    {
        $em = $this->getDoctrine()->getConnection('default');
        $req = $em->prepare($request->get('request'));
        $q = $request->get('exo');
        $question = $repository->find($q);
        $reponse = $em->prepare($question->getResultat());
        try {
            $req->execute();
            $reponse->execute();
            $result = $req->fetchAll();
            $rep = $reponse->fetchAll();
            $win = ($rep === $result);
            return $this->json(['response' => $result,'win'=>$win]);
        } catch (\Exception $exception) {
            return $this->json(['error' => explode(':',$exception->getMessage())[3]]);
        }
    }
}
