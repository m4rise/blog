<?php

namespace App\Notifications;

use App\Entity\Contact;
use Twig\Environment;

class ContactNotification
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $renderer;

    /**
     * ContactNotification constructor.
     * @param \Swift_Mailer $mailer
     * @param Environment $renderer
     */
    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function notify(Contact $contact)
    {
        #TODO envoi du message en HTML et non en raw
        $message = (new \Swift_Message($contact->getLastname().' '.$contact->getFirstname().' souhaite vous contacter'))
            ->setFrom('noreply@damien-duval.fr')
            ->setTo('contact@damien-duval.fr')
            ->setReplyTo($contact->getEmail())
            ->setBody($contact->getMessage());

        $this->mailer->send($message);
    }
}