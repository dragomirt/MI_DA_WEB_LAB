<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomeController extends AbstractController
{

    /** @Route(name="home", path="/")  */
    public function __invoke()
    {
        return $this->render("home.html.twig");
    }
}