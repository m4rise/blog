<?php


namespace App\Controller\Admin;


use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/comment")
 */
class AdminCommentController extends AbstractController
{

    private $commentRepository;

    private $em;

    public function __construct(CommentRepository $commentRepository, ObjectManager $em)
    {
        $this->commentRepository = $commentRepository;
        $this->em = $em;
    }

    /**
     * @Route("/", name="admin.comment.index", methods={"GET"})
     */
    public function index(): Response
    {
        $pendingComments = $this->commentRepository->allPendingComments();

        return $this->render('blog/admin/comment/index.html.twig', [
            'pendingComments' => $pendingComments
        ]);
    }

    /**
     * @Route("/validate/{id}", name="admin.comment.validate", methods={"POST"})
     */
    public function validate(Request $request, Comment $comment): Response
    {
        if ($this->isCsrfTokenValid('validate' . $comment->getId(), $request->request->get('_token'))) {
            $comment->setIsValidated(true);
            $this->em->flush();
        }

        return $this->redirectToRoute('admin.comment.index');
    }

    /**
     * @Route("/{id}", name="admin.comment.delete", methods={"DELETE"})
     */
    public function delete(Request $request, Comment $comment): Response
    {
        if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
            $this->em->remove($comment);
            $this->em->flush();
        }

        return $this->redirectToRoute('admin.comment.index');
    }
}