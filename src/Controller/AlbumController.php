<?php

namespace App\Controller;

use App\Entity\Album;
use Twig\Environment;
use App\Repository\AlbumRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\BrowserKit\Request;

class AlbumController extends AbstractController
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
     * @Route("/albums", name="albums", methods={"GET"})
     */
    public function listeAlbums(AlbumRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        // $albums = $repo->findAll();
        // $albums = $repo->findBy([],['nom'=>'asc']);
        $albums = $paginator->paginate(
            $repo->listeAlbumsComplete(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            9 /*limit per page*/
        );
        return $this->render('album/listeAlbums.html.twig', [ 
            'lesAlbums' => $albums
        ]);
    }
    /** 
    /**
     * @Route("/album/{id}", name="ficheAlbum", methods={"GET"})
    */
    public function ficheAlbum(int $id, AlbumRepository $repo): Response
    {
        $album = $repo->find($id);
        return new Response($this->twig->render('album/ficheAlbum.html.twig', [
            'leAlbum' => $album,
        ]));
    }
    /*public function ficheAlbum(Album $album)
    {
        return $this->render('album/ficheAlbum.html.twig', [
            'leAlbum' => $album
        ]);
        
    }*/
}
