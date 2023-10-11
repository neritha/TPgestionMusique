<?php

namespace App\Controller\Admin;

use App\Entity\Artiste;
use App\Form\ArtisteType;
use App\Repository\ArtisteRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArtisteController extends AbstractController
{
    /**
     * @Route("/admin/artistes", name="admin_artistes", methods={"GET"})
     */
    public function listeArtistes(ArtisteRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        $artiste = $paginator->paginate(
            $repo->listeArtisteComplete(),
            $request->query->getInt('page', 1),
            9
        );
        return $this->render('admin/artiste/listeArtistes.html.twig', [ 
            'lesArtistes' => $artiste
        ]);
    }

    /**
     * @Route("/admin/artiste/ajout", name="admin_artiste_ajout", methods={"GET","POST"})
     */
    public function ajoutArtiste(Request $request, EntityManagerInterface $manager): Response
    {
        $artiste=new Artiste();
        $form=$this->createForm(ArtisteType::class, $artiste);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        { 
            $manager->persist($artiste);
            $manager->flush();
            $this->addFlash("success","l'artiste à bien été ajouté"); //labelle, valeur
            return $this->redirectToRoute('admin_artistes');
        }

        //$form=$this->handleRequest($request);

        return $this->render('admin/artiste/formAjoutArtiste.html.twig', [ 
            'formArtiste' => $form->createView()
        ]);
    }
}
