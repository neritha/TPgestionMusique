<?php

namespace App\Controller;

use App\Repository\ArtisteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtisteController extends AbstractController
{
    /**
     * @Route("/artistes", name="artiste", methodes={"GET"})
     */
    public function listeArtistes(ArtisteRepository $repo): Response
    {
        $artistes = $repo->findAll();
        return $this->render('artiste/listeArtistes.html.twig', [
            'lesAtistes' => $artistes
        ]);
    }
}
