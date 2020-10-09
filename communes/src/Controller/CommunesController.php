<?php

namespace App\Controller;

use App\Entity\Communes;
use App\Repository\CommunesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CommunesController extends AbstractController
{
    /**
     * @Route("/communes", name="communes")
     * @param CommunesRepository $communesRepository
     * @return Response
     */
    public function index(CommunesRepository $communesRepository)
    {
        return $this->render('communes/index.html.twig', [
            'communes' => $communesRepository->findAll(),
        ]);
    }

    protected function serializeJson($objet){
        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getNom();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonContent = $serializer->serialize($objet, 'json');
        return $jsonContent;
    }

    /**
     * @Route("/json/communes", name="json_communes", methods={"GET"})
     * @param CommunesRepository $communesRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function jsonCommunes(CommunesRepository $communesRepository, Request $request)
    {
        $nom = $request->query->get('name');

        if ($nom === null) {
            $communes = $communesRepository->findAll();
        } else {
            $communes = $communesRepository->findBy(['nom' => $nom]);
        }

        return JsonResponse::fromJsonString($this->serializeJson($communes));

    }
}
