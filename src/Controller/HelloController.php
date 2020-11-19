<?php

namespace App\Controller;

use App\Entity\Appartement;
use App\Entity\DataImgPer;
use App\Entity\Personne;
use App\Entity\Residence;
use App\Repository\personneApart;
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

    /**
     * @Route("/findresi", name="findresi")
     */
    public function findResi(Request $request): Response
    {

        $id_res = json_decode($request->getContent(),true)['idss'];
        $residants = $this->getDoctrine()
            ->getRepository(DataImgPer::class)
            ->findBy(array('idRes' => $id_res));
            $jsonData = array();
            $idx = 0;
            foreach($residants as $residant) {
                $temp = array(
                    'Id' => $residant->getId(),
                    'Data' => $residant->getData(),
                    'Name' => $residant->getName(),
                );
                $jsonData[$idx++] = $temp;
            }
            return new JsonResponse($jsonData);
    }

    /**
     * @Route("/findpersappert", name="findpersappert")
     */
    public function findpersappert(Request $request): Response
    {
        $id_res = json_decode($request->getContent(),true)['idss'];
        $residants = $this->getDoctrine()
            ->getRepository(DataImgPer::class)
            ->findBy(array('idAppart' => $id_res));
        $jsonData = array();
        $idx = 0;
        foreach($residants as $residant) {
            $temp = array(
                'Id' => $residant->getId(),
                'Data' => $residant->getData(),
                'Name' => $residant->getName(),
            );
            $jsonData[$idx++] = $temp;
        }
        return new JsonResponse($jsonData);
    }
}
