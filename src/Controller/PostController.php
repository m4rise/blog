<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/articles")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="post.index")
     */
    public function index()
    {
        return $this->render('blog/post/index.html.twig', [
            'current_menu' => 'index'
        ]);
    }

    /**
     * @Route("/{slug}-{id}", name="post.show", requirements={"slug" = "[a-zA-Z0-9\-]+", "id" = "^\d+$" })
     */
    public function show()
    {
        #TODO Controller
        #return $this->render('blog/post/show.html.twig', [
        #'current_menu' => 'index'
        #]);
    }
}
