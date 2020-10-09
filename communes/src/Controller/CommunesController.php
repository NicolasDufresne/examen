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
        $nom = $request->query->get('nom');

        if ($nom === null) {
            $communes = $communesRepository->findAll();
        } else {
            $communes = $communesRepository->findBy(['nom' => $nom]);
        }

        return JsonResponse::fromJsonString($this->serializeJson($communes));

    }

    /**
     * @Route("json/communes/{nom}", name="communes_nom", methods={"GET"})
     * @param Communes $communes
     * @return JsonResponse
     */
    public function communesNom(Communes $communes)
    {
        return JsonResponse::fromJsonString($this->serializeJson($communes));
    }





    /**
     * @Route("/communes/json/create", name="communes_create", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function communesCreate(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $communes = new Communes();
        $communes->setNom($request->request->get("nom", "undefined"))
            ->setCode($request->request->get("code","undefined"))
            ->setCodeDepartement($request->request->get("code_departement","undefined"))
            ->setCodeRegion($request->request->get("code_region","undefined"))
            ->setCodesPostaux($request->request->get("codes_postaux","undefined"))
            ->setPopulation($request->request->get("population","undefined"));
        $entityManager->persist($communes);
        $entityManager->flush();
        $response = new Response();
        $response->setContent("Creation of commune with id " . $communes->getId());
        return $response;
    }

    /**
     * @Route("/communes/json/update", name="communes_update", methods={"PUT"})
     * @param Request $request
     * @param CommunesRepository $communesRepository
     * @return Response
     */
    public function communesUpdate(Request $request, CommunesRepository $communesRepository){
        $entityManager = $this->getDoctrine()->getManager();
        $data = json_decode(
            $request->getContent(),
            true
        );
        $response = new Response();
        if (isset($data['communes_id']) && isset($data['nom'])) {
            $id = $data['communes_id'];
            $communes = $communesRepository->find($id);
            if ($communes === null) {
                $response->setContent("Cette commune n'existe pas");
                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            } else {
                $communes->setNom($data['nom']);
                $entityManager->persist($communes);
                $entityManager->flush();
                $response->setContent("Modification de la commune");
                $response->setStatusCode(Response::HTTP_OK);
            }
        }else{
            $response->setContent("Erreur Bad Request");
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
        return $response;
    }

    /**
     * @Route("/communes/json/delete", name="communes_delete", methods={"DELETE"})
     * @param Request $request
     * @param CommunesRepository $communesRepository
     * @return Response
     */
    public function departementDelete(Request $request, CommunesRepository $communesRepository)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $response = new Response();
        $data = json_decode(
            $request->getContent(),
            true
        );
        if (isset($data["communes_id"]))
        {
            $communes = $communesRepository->find($data["communes_id"]);
            if ($communes === null)
            {
                $response->setContent("Cette commune n'existe pas");
                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            }
            else
            {
                $entityManager->remove($communes);
                $entityManager->flush();
                $response->setContent("Cette commune à été delete");
                $response->setStatusCode(Response::HTTP_OK);
            }
        }
        else
        {
            $response->setContent("L'id n'est pas renseigné");
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
        return $response;
    }

}
