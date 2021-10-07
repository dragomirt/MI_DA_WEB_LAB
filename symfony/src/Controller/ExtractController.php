<?php


namespace App\Controller;


use App\Entity\Product;
use App\Repository\ProductRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use thiagoalessio\TesseractOCR\TesseractOCR;

class ExtractController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    /** @Route(name="extract", path="/extract", methods={"POST"})  */
    public function __invoke(Request $request, LoggerInterface $logger)
    {
        $logger->info("Got a request for extraction");
        $raw_file = $request->files->get("file_to_extract");

        // Saving file
        $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
        $raw_file->move($destination, $raw_file->getClientOriginalName());
        $logger->info("Saved {$raw_file->getClientOriginalName()} to public storage");

        dd((new TesseractOCR($destination . '/' . $raw_file->getClientOriginalName()))
            ->lang('eng', 'ron', 'rus')
            ->run());

        return new JsonResponse(['extracted'=> true]);
    }
}