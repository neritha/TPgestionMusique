<?php

namespace App\Controller;

use Twig\Environment;
use App\Entity\Artiste;
use App\Repository\ArtisteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\twig;

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
    public function listeArtistes(ArtisteRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        // $artistes = $repo->findAll();
        $artiste = $paginator->paginate(
            $repo->listeArtisteComplete(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            9 /*limit per page*/
        );
        return $this->render('artiste/listeArtistes.html.twig', [ 
            'lesArtistes' => $artiste
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
