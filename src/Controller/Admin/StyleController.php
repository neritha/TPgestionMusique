<?php

namespace App\Controller\Admin;

use App\Entity\Style;
use App\Form\StyleType;
use App\Repository\StyleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StyleController extends AbstractController
{
 /**
     * @Route("/admin/styles", name="admin_styles", methods={"GET"})
     */
    public function listeStyles(StyleRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        $styles = $paginator->paginate(
            $repo->listeStyleComplete(),
            $request->query->getInt('page', 1),
            9
        );
        return $this->render('admin/style/listeStyles.html.twig', [ 
            'lesStyles' => $styles
        ]);
    }


     /**
     * @Route("/admin/style/ajout", name="admin_style_ajout", methods={"GET","POST"})
     * @Route("/admin/style/modif/{id}", name="admin_style_modif", methods={"GET","POST"})
     */
    public function ajoutModifStyle(Style $style=null, Request $request, EntityManagerInterface $manager): Response
    {
       
        if($style == null){
            $style=new Style();
            $mode="ajouté";
        }else{
            $mode="modifié";
        }

        $form=$this->createForm(StyleType::class, $style); // formulaire qu'on a pas encore fait

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        { 
            $manager->persist($style);
            $manager->flush();
            $this->addFlash("success","le style à bien été $mode"); //labelle, valeur
            return $this->redirectToRoute('admin_styles');
        }

        //$form=$this->handleRequest($request);

        return $this->render('admin/style/formAjoutModifStyle.html.twig', [ 
            'formStyle' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/style/suppression/{id}", name="admin_style_suppression", methods={"GET"})
     */
    public function suppressionStyle(Style $style, EntityManagerInterface $manager): Response
    {

        $nbAlbums = $style->getAlbums()->count();

        if ($nbAlbums > 0){
            $this->addFlash("warning","le style n'a pas pu être suprimmé car il possède $nbAlbums albume");
        }else{
            $manager->remove($style);
            $manager->flush();
            $this->addFlash("success","le style à bien été supprimé"); //labelle, value
        }

        return $this->redirectToRoute('admin_artistes');
    }


}
