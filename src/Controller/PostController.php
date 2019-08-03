<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/articles")
 */
class PostController extends AbstractController
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @Route("/", name="post.index")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $posts = $paginator->paginate(
            $this->postRepository->allOrderedPostsQuery(),
            $request->query->getInt('p', 1),
            15
        );

        return $this->render('blog/post/index.html.twig', [
            'current_menu' => 'index',
            'paginatedPosts' => $posts
        ]);
    }

    /**
     * @Route("/{slug}-{id}", name="post.show", requirements={"slug" = "[a-zA-Z0-9\-]+", "id" = "^\d+$" })
     */
    public function show()
    {
        #TODO Controller
    }
}
