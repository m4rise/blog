<?php

namespace App\Controller;

use App\Entity\Post;
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
    public function show(Post $post, string $slug)
    {
        // redirection si le slug ne correspond pas à l'id (référencement)
        if($post->getSlug() !== $slug) {
            return $this->redirectToRoute('post.show', [
                'id' => $post->getId(),
                'slug' => $post->getSlug()
            ], 301);
        }

        return $this->render('blog/post/show.html.twig', [
            'current_menu' => 'index',
            'post' => $post
        ]);
    }
}
