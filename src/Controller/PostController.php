<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(PostRepository $postRepository, EntityManagerInterface $em)
    {
        $this->postRepository = $postRepository;
        $this->em = $em;
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
            'current_menu' => 'post.index',
            'paginatedPosts' => $posts
        ]);
    }

    /**
     * @Route("/{slug}-{id}", name="post.show", requirements={"slug" = "[a-zA-Z0-9\-]+", "id" = "^\d+$" })
     */
    public function show(Post $post, string $slug, Request $request)
    {
        // redirection si le slug ne correspond pas à l'id (référencement)
        if ($post->getSlug() !== $slug) {
            return $this->redirectToRoute('post.show', [
                'id' => $post->getId(),
                'slug' => $post->getSlug()
            ], 301);
        }

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment
                ->setAuthor($this->getUser())
                ->setPost($post)
            ;
            $this->em->persist($comment);
            $this->em->flush();
            $this->addFlash('comment.success', 'Merci pour votre commentaire, il sera bientôt affiché après vérification');

            return $this->redirectToRoute('post.show', [
                'slug' => $post->getSlug(),
                'id' => $post->getId()
            ]);
        }

        return $this->render('blog/post/show.html.twig', [
            'current_menu' => 'post.index',
            'post' => $post,
            'form' => $form->createView()
        ]);
    }
}
