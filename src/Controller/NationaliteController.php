<?php

namespace App\Controller;

use App\Repository\NationaliteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NationaliteController extends AbstractController
{
    /**
     * @Route("/admin/nationalites", name="nationalites_statistiques", methods={"GET"})
     */
    // public function index(): Response
    // {
    //     return $this->render('nationalite/index.html.twig', [
    //         'controller_name' => 'NationaliteController',
    //     ]);
    // }

    // /**
    //  * @Route("/admin/nationalites", name="nationalites_statistiques", methods={"GET"})
    //  */
    // public function listeNationalites(NationaliteRepository $repo, PaginatorInterface $paginator, Request $request): Response
    // {
    //     $nationalite = $paginator->paginate(
    //         $repo->listeNationaliteComplete(),
    //         $request->query->getInt('page', 1),
    //         9
    //     );
    //     return $this->render('admin/nationalite/listeNationalites.html.twig', [ 
    //         'lesNationalites' => $nationalite
    //     ]);
    // }

    /**
     * @Route("nationalites", name="nationalites_statistiques", methods={"GET"})
     */
    public function listeNationalites(NationaliteRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        $nationalite = $paginator->paginate(
            $repo->listeNationaliteComplete(),
            $request->query->getInt('page', 1),
            9
        );
        return $this->render('nationalite/statistiques.html.twig', [ 
            'lesNationalites' => $nationalite
        ]);
    }
// /**
//      * @Route("nationalites", name="nationalites_statistiques", methods={"GET"})
//      */
//     public function listeNationalites(NationaliteRepository $repo): Response
//     {
//         $nationalites = $repo->listeNationaliteComplete();

//         return $this->render('nationalite/statistiques.html.twig', [ 
//             'lesNationalites' => $nationalites
//         ]);
//     }





 }
