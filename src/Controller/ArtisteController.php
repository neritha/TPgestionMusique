<?php

namespace App\Controller;

use App\Entity\Artiste;
use App\Repository\ArtisteRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\twig;
use Twig\Environment;



class ArtisteController extends AbstractController
{

        private $twig;

        public function __construct(Environment $twig)
        {
            $this->twig = $twig;
        }
    

    /*public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }*/
    /**
     * @Route("/artistes", name="artistes", methods={"GET"})
     */
    public function listeArtistes(ArtisteRepository $repo): Response
    {
        $artistes = $repo->findAll();
        return $this->render('artiste/listeArtistes.html.twig', [
            'lesArtistes' => $artistes
        ]);
    }
    /** 
    /**
     * @Route("/artiste/{id}", name="ficheArtiste", methods={"GET"})
    */
    public function ficheArtiste(int $id, ArtisteRepository $repo): Response
    {
        $artiste = $repo->find($id);
        return new Response($this->twig->render('artiste/ficheArtiste.html.twig', [
            'leArtiste' => $artiste,
        ]));
    }
    /*public function ficheArtiste(Artiste $artiste)
    {
        return $this->render('artiste/ficheArtiste.html.twig', [
            'leArtiste' => $artiste
        ]);
        
    }*/
}
