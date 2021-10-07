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
        $filename = $raw_file->getClientOriginalName();
        $raw_file->move($destination, $filename);
        $logger->info("Saved {$filename} to public storage");

        $imglink = '/uploads/' . $filename;

        $content = (new TesseractOCR($destination . '/' . $filename))
            ->lang('eng', 'ron', 'rus')
            ->run();

        return $this->render('result.html.twig', ['content' => $content, 'filename' => $filename, 'imglink' => $imglink]);
    }
}