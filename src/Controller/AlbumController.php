<?php

namespace App\Controller;

use Twig\Environment;
use App\Repository\AlbumRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function listeAlbums(AlbumRepository $repo): Response
    {
        $albums = $repo->findAll();
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
