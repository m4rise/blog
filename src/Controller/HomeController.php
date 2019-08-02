<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Notifications\ContactNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param Request $request
     * @param ContactNotification $notification
     * @return Response
     */
    public function home(Request $request, ContactNotification $notification): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $notification->notify($contact);
            $this->addFlash('contact.success', 'Votre message a bien été envoyé, je vous recontacterai dans les meilleurs délais.');
            return $this->redirectToRoute('home', ['_fragment' => 'contact']);
        }

        return $this->render('blog/home.html.twig', [
            'current_menu' => 'home',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/cv", name="cv")
     */
    public function downloadCV()
    {
        $file = '../ressources/CV_DUVAL_Damien.pdf';
        $response = new BinaryFileResponse($file);
        $response->headers->set('Content-Type', 'application/pdf');
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            'CV_DUVAL_Damien.pdf'
        );
        return $response;
    }
}
