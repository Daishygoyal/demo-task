<?php

namespace App\Controller\Api;

use App\Entity\Fruits;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Tools\Pagination\Paginator;

#[Route('/api', name: 'app_')]
class FruitsController extends AbstractController
{
    #[Route('/fruits', name: 'fruits' )]
    public function getFruits(Request $request,  EntityManagerInterface $entityManager): JsonResponse
    {
        $page = $request->query->get("page") ? $request->query->get("page") : 1;
        $name = $request->query->get("name");
        $family = $request->query->get("family");
        $fruitsPaginatedData = $entityManager->getRepository(Fruits::class)->getPaginatedFruits($page, $name, $family);

        return $this->json([
            'status' => 'true',
            'data' => $fruitsPaginatedData
        ]);
    }

    #[Route('/make-favourite/{id}', name: 'make_favorite' )]
    public function setFavourite(Fruits $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $favouritesCount = $entityManager->getRepository(Fruits::class)->count(['isFavourite'=>true]);

        if($id->getIsFavourite()){
            return $this->json([
                "status"=>"false",
                "message"=>"Already added as favourite"
            ]);
        }

        if($favouritesCount>=10){
            return $this->json([
                "status"=>"false",
                "message"=>"Only 10 favourites allowed"
            ]);
        }

        $id->setIsFavourite(true);
        $entityManager->persist($id);
        $entityManager->flush();

        return $this->json([
            "status"=>"true",
            "message"=>"Added as favourite"
        ]);
    }

    #[Route('/get-favourite/{page<\d+>?1}', name: 'get_favorite' )]
    public function getFavourite(int $page, EntityManagerInterface $entityManager): JsonResponse
    {
        $fruitsPaginatedData = $entityManager->getRepository(Fruits::class)->getPaginatedFavourites($page);

        return $this->json([
            'status' => 'true',
            'data' => $fruitsPaginatedData
        ]);
    }
}
