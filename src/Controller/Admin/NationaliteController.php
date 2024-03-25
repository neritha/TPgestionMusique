<?php

namespace App\Controller\Admin;

use App\Entity\Nationalite;
use App\Form\NationaliteType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\NationaliteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NationaliteController extends AbstractController
{
    // #[Route('/admin/Nationalite', name: 'app_admin_Nationalite')]
    // public function index(): Response
    // {
    //     return $this->render('admin/nationalite/index.html.twig', [
    //         'controller_name' => 'nationaliteController',
    //     ]);
    // }


    
    /**
     * @Route("/admin/nationalites", name="admin_nationalites", methods={"GET"})
     */
    public function listeNationalites(NationaliteRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        $nationalite = $paginator->paginate(
            $repo->listeNationaliteComplete(),
            $request->query->getInt('page', 1),
            9
        );
        return $this->render('admin/nationalite/listeNationalites.html.twig', [ 
            'lesNationalites' => $nationalite
        ]);
    }


    /**
     * @Route("/admin/nationalite/suppression/{id}", name="admin_nationalite_suppression", methods={"GET"})
     */
    public function suppressionNationalite(Nationalite $nationalite, EntityManagerInterface $manager): Response
    {

        // $nbAlbums = $artiste->getAlbums()->count();
        $nbArtiste = $nationalite->getArtistes()->count();

        if ($nbArtiste > 0){
            $this->addFlash("warning","la nationalite n'a pas pu être suprimmé car $nbArtiste la possède");
        }else{
            $manager->remove($nationalite);
            $manager->flush();
            $this->addFlash("success","la nationaite à bien été supprimé"); //labelle, value
        }

        return $this->redirectToRoute('admin_nationalites');
    }



    /**
     * @Route("/admin/nationalite/ajout", name="admin_nationalite_ajout", methods={"GET","POST"})
     * @Route("/admin/nationalite/modif/{id}", name="admin_nationalite_modif", methods={"GET","POST"})
     */
    public function ajoutModifNationalite(Nationalite $nationalite=null, Request $request, EntityManagerInterface $manager): Response
    {
       
        if($nationalite == null){
            $nationalite=new Nationalite();
            $mode="ajouté";
        }else{
            $mode="modifié";
        }

        $form=$this->createForm(NationaliteType::class, $nationalite);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        { 
            $manager->persist($nationalite);
            $manager->flush();
            $this->addFlash("success","la nationalite à bien été $mode"); //labelle, valeur
            return $this->redirectToRoute('admin_nationalites');
        }

        //$form=$this->handleRequest($request);

        return $this->render('admin/nationalite/formAjoutModifNationalite.html.twig', [ 
            'formNationalite' => $form->createView()
        ]);
    }



}
