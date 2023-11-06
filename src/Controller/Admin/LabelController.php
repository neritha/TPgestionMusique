<?php

namespace App\Controller\Admin;

use App\Entity\Label;
use App\Form\LabelType;
use App\Repository\LabelRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LabelController extends AbstractController
{
    /**
     * @Route("/admin/labels", name="admin_labels", methods={"GET"})
     */
    public function listeLabel(LabelRepository $repo): Response
    {
        $label = $repo->findAll();

        return $this->render('admin/label/listeLabels.html.twig', [ 
            'lesLabels' => $label
        ]);
    }

    /**
     * @Route("/admin/label/ajout", name="admin_label_ajout", methods={"GET","POST"})
     * @Route("/admin/label/modif/{id}", name="admin_label_modif", methods={"GET","POST"})
     */
    public function ajoutModifLabel(Label $label=null, Request $request, EntityManagerInterface $manager): Response
    {
       
        if($label == null){
            $label=new Label();
            $mode="ajouté";
        }else{
            $mode="modifié";
        }

        $form=$this->createForm(LabelType::class, $label);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        { 
            $manager->persist($label);
            $manager->flush();
            $this->addFlash("success","le label à bien été $mode"); //labelle, valeur
            return $this->redirectToRoute('admin_labels');
        }

        //$form=$this->handleRequest($request);

        return $this->render('admin/label/formAjoutModifLabel.html.twig', [ 
            'formLabel' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/label/suppression/{id}", name="admin_label_suppression", methods={"GET"})
     */
    public function suppressionLabel(Label $label, EntityManagerInterface $manager): Response
    {

        $nbAlbums = $label->getAlbums()->count();

        if ($nbAlbums > 0){
            $this->addFlash("warning","le label n'a pas pu être suprimmé car il possède $nbAlbums albume");
        }else{
            $manager->remove($label);
            $manager->flush();
            $this->addFlash("success","le labele à bien été supprimé"); //labelle, value
        }

        return $this->redirectToRoute('admin_labels');
    }



}
