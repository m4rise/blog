<?php


namespace App\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin")
 */
class AdminBaseController extends AbstractController
{
    /**
     * @Route("/", name="admin.index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('blog/admin/index.html.twig');
    }
}