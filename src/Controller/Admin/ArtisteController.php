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
     * @Route("/admin/artiste/modif/{id}", name="admin_artiste_modif", methods={"GET","POST"})
     */
    public function ajoutModifArtiste(Artiste $artiste=null, Request $request, EntityManagerInterface $manager): Response
    {
       
        if($artiste == null){
            $artiste=new Artiste();
            $mode="ajouté";
        }else{
            $mode="modifié";
        }

        $form=$this->createForm(ArtisteType::class, $artiste);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        { 
            $manager->persist($artiste);
            $manager->flush();
            $this->addFlash("success","l'artiste à bien été $mode"); //labelle, valeur
            return $this->redirectToRoute('admin_artistes');
        }

        //$form=$this->handleRequest($request);

        return $this->render('admin/artiste/formAjoutModifArtiste.html.twig', [ 
            'formArtiste' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/artiste/suppression/{id}", name="admin_artiste_suppression", methods={"GET"})
     */
    public function suppressionArtiste(Artiste $artiste, EntityManagerInterface $manager): Response
    {

        $nbAlbums = $artiste->getAlbums()->count();

        if ($nbAlbums > 0){
            $this->addFlash("warning","l'artiste n'a pas pu être suprimmé car il possède $nbAlbums albume");
        }else{
            $manager->remove($artiste);
            $manager->flush();
            $this->addFlash("success","l'artiste à bien été supprimé"); //labelle, value
        }

        return $this->redirectToRoute('admin_artistes');
    }


    /**
     * @Route("/admin/artiste/modif{id}", name="admin_artiste_modif", methods={"GET","POST"})
     */
/*    public function modifArtiste(Artiste $artiste, Request $request, EntityManagerInterface $manager): Response
    {
        
        $form=$this->createForm(ArtisteType::class, $artiste);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        { 
            $manager->persist($artiste);
            $manager->flush();
            $this->addFlash("success","l'artiste à bien été modofié"); //labelle, valeur
            return $this->redirectToRoute('admin_artistes');
        }

        //$form=$this->handleRequest($request);

        return $this->render('admin/artiste/formModifArtiste.html.twig', [ 
            'formArtiste' => $form->createView()
        ]);
    }*/
}
