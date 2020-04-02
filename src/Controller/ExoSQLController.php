<?php

namespace App\Controller;

use App\Entity\ExoSQL;
use App\Form\ExoSQLType;
use App\Repository\ExoSQLRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/exo/sql")
 */
class ExoSQLController extends AbstractController
{
    /**
     * @Route("/", name="exo_sql_index", methods={"GET"})
     */
    public function index(ExoSQLRepository $exoSQLRepository): Response
    {
        return $this->render('sql-editor/editor.html.twig', [
            'exo_sqls' => $exoSQLRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="exo_sql_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $exoSQL = new ExoSQL();
        $form = $this->createForm(ExoSQLType::class, $exoSQL);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($exoSQL);
            $entityManager->flush();

            return $this->redirectToRoute('exo_sql_index');
        }

        return $this->render('exo_sql/new.html.twig', [
            'exo_sql' => $exoSQL,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="exo_sql_show", methods={"GET"})
     */
    public function show(ExoSQL $exoSQL): Response
    {
        return $this->render('exo_sql/show.html.twig', [
            'exo_sql' => $exoSQL,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="exo_sql_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ExoSQL $exoSQL): Response
    {
        $form = $this->createForm(ExoSQLType::class, $exoSQL);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('exo_sql_index');
        }

        return $this->render('exo_sql/edit.html.twig', [
            'exo_sql' => $exoSQL,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="exo_sql_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ExoSQL $exoSQL): Response
    {
        if ($this->isCsrfTokenValid('delete'.$exoSQL->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($exoSQL);
            $entityManager->flush();
        }

        return $this->redirectToRoute('exo_sql_index');
    }
}
