<?php

namespace App\Controller;

use Twig\Environment;
use App\Entity\Artiste;
use App\Repository\LabelRepository;
use App\Repository\ArtisteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\twig;

class LabelController extends AbstractController
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
     * @Route("/labels", name="labels", methods={"GET"})
     */
    public function listeLabel(LabelRepository $repo): Response
    {
        $label = $repo->findAll();

        return $this->render('label/listeLabels.html.twig', [ 
            'lesLabels' => $label
        ]);
    }
    /** 
    /**
     * @Route("/label/{id}", name="ficheLabel", methods={"GET"})
    */
    public function ficheLabel(int $id, LabelRepository $repo): Response
    {
        $label = $repo->find($id);
        return new Response($this->twig->render('label/ficheLabel.html.twig', [
            'leLabel' => $label,
        ]));
    }
    /*public function ficheArtiste(Artiste $artiste)
    {
        return $this->render('artiste/ficheArtiste.html.twig', [
            'leArtiste' => $artiste
        ]);
        
    }*/
}
