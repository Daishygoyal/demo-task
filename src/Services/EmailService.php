<?php

namespace App\Services;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

class EmailService
{
    public function __construct(private MailerInterface $mailer){
    }

    public function send($to, $subject, $templatePath, $templateData) {

        $email = (new TemplatedEmail())
            ->from('test@example.com')
            ->to(new Address($to))
            ->addCc($to)
            ->subject($subject)

            // path of the Twig template to render
            ->htmlTemplate($templatePath)

            // pass variables ([name => value]) to the template
            ->context($templateData)
        ;

        $this->mailer->send($email);

    }
}