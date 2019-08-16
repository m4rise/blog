<?php

namespace App\Notifications;

use App\Entity\Contact;
use App\Framework\Mailer\MailerInterface;
use Twig\Environment;

class ContactNotification
{
    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $renderer;

    /**
     * ContactNotification constructor.
     * @param MailerInterface $mailer
     * @param Environment $renderer
     */
    public function __construct(MailerInterface $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function notify(Contact $contact): void
    {
        #TODO envoi du message en HTML et non en raw

        $subject = $contact->getLastname() . ' ' . $contact->getFirstname() . ' souhaite vous contacter';

        $this->mailer->send(
            $contact->getEmail(),
            ['contact@damien-duval.fr'],
            $subject,
            $contact->getMessage()
        );
    }
}