<?php

namespace App\Controller;

use App\Entity\Appartement;
use App\Form\AppartementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/appartement")
 */
class AppartementController extends AbstractController
{
    /**
     * @Route("/", name="appartement_index", methods={"GET"})
     */
    public function index(): Response
    {
        $appartements = $this->getDoctrine()
            ->getRepository(Appartement::class)
            ->findAll();

        return $this->render('appartement/index.html.twig', [
            'appartements' => $appartements,
        ]);
    }

    /**
     * @Route("/new", name="appartement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $appartement = new Appartement();
        $form = $this->createForm(AppartementType::class, $appartement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($appartement);
            $entityManager->flush();

            return $this->redirectToRoute('appartement_index');
        }

        return $this->render('appartement/new.html.twig', [
            'appartement' => $appartement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idAppart}", name="appartement_show", methods={"GET"})
     */
    public function show(Appartement $appartement): Response
    {
        return $this->render('appartement/show.html.twig', [
            'appartement' => $appartement,
        ]);
    }

    /**
     * @Route("/{idAppart}/edit", name="appartement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Appartement $appartement): Response
    {
        $form = $this->createForm(AppartementType::class, $appartement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('appartement_index');
        }

        return $this->render('appartement/edit.html.twig', [
            'appartement' => $appartement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idAppart}", name="appartement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Appartement $appartement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$appartement->getIdAppart(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($appartement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('appartement_index');
    }
}
