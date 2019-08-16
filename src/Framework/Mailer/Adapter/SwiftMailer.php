<?php


namespace App\Framework\Mailer\Adapter;

use App\Framework\Mailer\MailerInterface;
use Swift_Mailer;
use Swift_Message;

final class SwiftMailer implements MailerInterface
{
    private $mailer;

    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(string $from, array $recipients, string $subject, string $body): void
    {
        $swiftMessage = (new Swift_Message($subject))
            ->setFrom('noreply@damien-duval.fr')
            ->setReplyTo($from)
            ->setTo($recipients)
            ->setBody($body);

        $this->mailer->send($swiftMessage);
    }
}