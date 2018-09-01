<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function home()
    {
        $data = file_get_contents(__DIR__ . '/../../config/weakauras.json');

        $content = json_decode($data, true);

        return $this->render('weakauras.html.twig', ['content' => $content]);
    }
}