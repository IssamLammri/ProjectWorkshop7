<?php

namespace App\Controller;

use App\Entity\Appartement;
use App\Entity\Residence;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class HelloController extends AbstractController
{
    /**
     * @Route("/hello", name="hello")
     */
    public function index(): Response
    {
        $residences = $this->getDoctrine()
            ->getRepository(Residence::class)
            ->findAll();
        $appartements = $this->getDoctrine()
            ->getRepository(Appartement::class)
            ->findAll();

        return $this->render('hello/index.html.twig', [
            'controller_name' => 'HelloController',
            'residences' => $residences,
            'appartements' => $appartements,
        ]);
    }

    /**
     * @Route("/findappar", name="findappar")
     */
    public function findAppar(Request $request): Response
    {
        $id_res = $request->request->get('idss');
        $appartements = $this->getDoctrine()
            ->getRepository(Appartement::class)
            ->findBy(array('idResi' => $id_res));
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $jsonData = array();
            $idx = 0;
            foreach($appartements as $appartement) {
                $temp = array(
                    'id' => $appartement->getIdAppart(),
                    'NumApp' => $appartement->getNumeroAppart(),
                );
                $jsonData[$idx++] = $temp;
            }
            return new JsonResponse($jsonData);
        } else {
            $residences = $this->getDoctrine()
                ->getRepository(Residence::class)
                ->findAll();
            return $this->render('hello/index.html.twig', [
                'controller_name' => 'HelloController',
                'residences' => $residences,
                'appartements' => $appartements,
            ]);
        }

    }
}
