<?php


namespace App\Framework\Mailer;


interface MailerInterface
{

    public function send(string $from, array $to, string $subject, string $body): void;

}