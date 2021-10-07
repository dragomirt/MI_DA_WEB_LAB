<?php


namespace App\Controller;


use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ExtractController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    /** @Route(name="extract", path="/extract")  */
    public function __invoke()
    {
//        $em = $this->getDoctrine()->getManager();
//        /** @var ProductRepository $repo */
//        $repo = $em->getRepository(Product::class);
//        $repo->findAll();
        return new JsonResponse(['extracted'=> true]);
    }
}